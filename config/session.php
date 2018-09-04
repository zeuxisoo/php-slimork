<?php
return [
    'name'     => env('SESSION_NAME', '_sk'),
    'lifetime' => env('SESSION_LIFETIME', 7200), // 2 hour
    'path'     => env('SESSION_PATH', '/'),
    'domain'   => env('SESSION_DOMAIN', null),
    'secure'   => false,
    'httponly' => true,
    'handler'  => null,
    'ini_sets' => [
        'cache_limiter' => 'nocache',
        'cache_expire'  => 180
    ]
];
