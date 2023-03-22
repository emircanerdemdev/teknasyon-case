<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DeviceSubscription extends Model
{
    protected $table = "device_subscriptions";

    protected $fillable = ["device_id", "app_id", "client_token", "receipt" , "status", "response", "expire_date"];


    public function scopeDeviceId($query, $deviceId)
    {
        return $query->where("device_id", $deviceId);
    }

    public function scopeAppId($query, $appId)
    {
        return $query->where("app_id", $appId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where("status", $status);
    }

    public static function getActiveSubscriptionByDeviceIdAndAppId($deviceId, $appId)
    {
        return self::appId($appId)->deviceId($deviceId)->status(true)->first();
    }

    public static function createDeviceSubscription($deviceId, $appId, $serverResponse, $clientToken , $receipt)
    {
        $activeSubscription = self::getActiveSubscriptionByDeviceIdAndAppId($deviceId, $appId);
        if (!is_null($activeSubscription))
            return null;

        $subscription = new self();
        $subscription->device_id = $deviceId;
        $subscription->app_id = $appId;
        $subscription->client_token = $clientToken;
        $subscription->receipt = $receipt;
        $subscription->status = $serverResponse["status"];
        $subscription->expire_date = $serverResponse["expire_date"];
        $subscription->response = json_encode($serverResponse);
        $subscription->save();
        return $subscription;
    }
}
