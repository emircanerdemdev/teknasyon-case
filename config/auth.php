<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'devices',
    ],
    
    'guards' => [
        'api' => [
            'driver' => 'token',
            'provider' => 'devices',
            'hash' => false,
        ],
    ],
    
    'providers' => [
        'devices' => [
            'driver' => 'eloquent',
            'model' => App\Models\Device::class,
        ],
    ],
    
    'passwords' => [
        'devices' => [
            'provider' => 'devices',
            'table' => 'password_resets',
            'expire' => 60,
        ],
    ],
];