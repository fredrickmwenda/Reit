<?php

return [
    'property_id' => env('ANALYTICS_PROPERTY_ID', 'XXXXXXXXX'),
    'service_account_credentials_json' => storage_path('app/analytics/vilhive-57a16f31ee03.json'),
    'cache' => [
        'enableCaching' => env('ANALYTICS_CACHE', false),
        'authCache' => null,
        'authCacheOptions' => [
            'lifetime' => env('ANALYTICS_CACHE_LIFETIME', 60),
            'prefix' => env('ANALYTICS_CACHE_PREFIX', 'analytics_'),
        ],
    ],
];  

