<?php

namespace App\Http\Controllers;

use App\Models\DeviceSubscription;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscriptionInfo()
    {
        $device = Auth::user();
        $activeSubscription = DeviceSubscription::getActiveSubscriptionByDeviceIdAndAppId($device->id, $device->app_id);
        return $this->respondSuccessResponse(["subscription" => $activeSubscription]);
    }
}
