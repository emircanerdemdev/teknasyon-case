<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Device;
use Illuminate\Support\Str;

class DeviceController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $device = Device::register($request->uid, $request->app_id, $request->language, $request->os);
        $token = hash('sha256', Str::random(60));
        $device = Device::updateToken($device, $token);
        return $this->respondSuccessResponse(["device" => $device]);
    }
}