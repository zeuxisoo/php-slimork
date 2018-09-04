<?php
return [
    'expires'   => new DateTime('+3 hours'),
    'path'      => env('COOKIE_PATH', '/'),
    'domain'    => env('COOKIE_DOMAIN', null),
    'secure'    => false,
    'http_only' => true,
];
