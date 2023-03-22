<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return json_encode([
        "project" => "Teknasyon",
        "version" => 1.000
    ]);
});

Route::get('/login', function () {
    return response()->json([
        "status" => "fail",
        "message" => "Login Required",
        "error" => [
            "code" => 401,
            "message" => "Login Required",
            "errors" => "Token is not exist or invalid"
        ]
    ], 401);
})->name('login');

Route::group(['prefix' => 'device'], function ($router) {
    $router->post('/register', 'DeviceController@register')->name('post.device.register');
});

Route::group(['prefix' => 'purchase' , 'middleware' => "auth"], function ($router) {
    $router->post('/complete', 'PurchaseController@purchase')->name('post.purchase.complete');
});

Route::group(['prefix' => 'subscription', 'middleware' => "auth"], function ($router) {
    $router->get('/info', 'SubscriptionController@subscriptionInfo')->name('get.subscription.info');
});
