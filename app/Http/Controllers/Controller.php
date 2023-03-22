<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function respondFailedResponse($message = null, $responseCode = 400, $data = null,$params = [])
    {
        return response()->json([
            'status' => "error",
            'error' => [
                "code" => $responseCode,
                "message" => is_null($message) ? "Invalid request" : $message
            ],
            "params" => $params,
            "data" => $data
        ], $responseCode);
    }

    protected function respondSuccessResponse($data, $params = [])
    {
        return [
            "status" => "success",
            "params" => $params,
            "data" => $data
        ];
    }
}
