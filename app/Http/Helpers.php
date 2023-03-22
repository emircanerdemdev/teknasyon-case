<?php

use App\Models\Device;
use Carbon\Carbon;

if (!function_exists('check_receipt')) {
    function check_receipt($platform, $userToken, $receiptHash)
    {
        $status = false;
        $expireDate = null;
        $response = null;

        try {
            // Platforma göre istek atılıp sonuç işlenebilir. 
            // Ben test amacı ile olduğu için caselerin üstünde işlem yaptım
            $lastCharacter = substr($receiptHash, -1);
            $val = intval($lastCharacter);
            $status = $val % 2 != 0;
            if($status)
                $expireDate = Carbon::now()->addMonths(12)->setTimezone("UTC")->subHours(6)->format("Y-m-d H:i:s");

            switch ($platform) {
                case Device::OS_TYPES["ANDROID"]:
                    break;
                case Device::OS_TYPES["IOS"]:
                    break;
            }
        } catch (Exception $e) {
            return ["status" => $status, "expire_date" => $expireDate, "response" => $response];
        }
    }
}
