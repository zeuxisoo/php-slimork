<?php
return [
    'name'     => '_sk',
    'lifetime' => 7200, // 2 hour
    'path'     => '/',
    'domain'   => null,
    'secure'   => false,
    'httponly' => true,
    'handler'  => null,
    'ini_sets' => [
        'cache_limiter' => 'nocache',
        'cache_expire'  => 180
    ]
];
