<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpiredSubscriptionChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expired-subscription-checker';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check Expired Subscriptions. Runs every minute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $limit = 10000; // can be reduce for system reqiurements
        
        $expiredSubscriptions = DB::table("device_subscriptions")
            ->select(
                "device_subscriptions.id as device_subscriptions_id",
                "device_subscriptions.client_token",
                "device_subscriptions.receipt",
                "devices.*"
            )
            ->join('devices', 'devices.id', '=', 'device_subscriptions.device_id')
            ->where("status", true)
            ->where("expire_date", "<", Carbon::now())
            ->limit($limit)
            ->get();

        foreach ($expiredSubscriptions as $expiredSubscription) {
            $purchaseResult = check_receipt($expiredSubscription->os, $expiredSubscription->client_token, $expiredSubscription->receipt);
            DB::table("device_subscriptions")->whereId($expiredSubscription->device_subscriptions_id)->update([
                "status" => $purchaseResult["status"],
                "expire_date" => $purchaseResult["expire_date"]
            ]);
        }
        return 0;
    }
}