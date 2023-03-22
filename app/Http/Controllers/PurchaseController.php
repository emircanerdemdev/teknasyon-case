<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use App\Models\DeviceSubscription;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function purchase(PurchaseRequest $request)
    {
        $device = Auth::user();
        $currentSubscription = DeviceSubscription::getActiveSubscriptionByDeviceIdAndAppId($device->id, $device->app_id);
        if (!is_null($currentSubscription))
            return $this->respondFailedResponse("You have already subscribed", 422);

        $purchaseResult = check_receipt($device->os, $request->client_token, $request->receipt);
        if (!$purchaseResult["status"])
            return $this->respondFailedResponse("Receipt is not valid", 422);

        DeviceSubscription::createDeviceSubscription($device->id, $device->app_id, $purchaseResult, $request->client_token, $request->receipt);
        return $this->respondSuccessResponse(["purchase_result" => $purchaseResult]);
    }
}
