<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Device extends Model
{
    use HasApiTokens;

    protected $table = "devices";

    protected $fillable = ["api_token", "uid", "app_id", "language", "os"];

    const OS_TYPES = [
        1 => "ANDROID",
        2 => "IOS"
    ];
    
    const LANGUAGES = [
        1 => "TURKISH",
        2 => "ENGLISH"
    ];

    const APPS = [
        1 => "APP ONE",
        2 => "APP TWO"
    ];

    public function scopeUid($query, $uid)
    {
        return $query->where("uid", $uid);
    }

    public function scopeAppId($query, $appId)
    {
        return $query->where("app_id", $appId);
    }

    public static function getDeviceByUidAndAppId($uid, $appId)
    {
        return self::uid($uid)->appId($appId)->first();
    }

    public static function register($uid, $appId, $language, $os)
    {
        $device = self::getDeviceByUidAndAppId($uid, $appId);
        if (is_null($device))
            $device = new self();

        $device->uid = $uid;
        $device->app_id = $appId;
        $device->language = $language;
        $device->os = $os;
        $device->save();
        return $device;
    }

    public static function updateToken($device, $token)
    {
        $device->api_token = $token;
        $device->save();
        return $device;
    }
}
