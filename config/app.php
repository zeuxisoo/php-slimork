<?php
return [
    'timezone' => 'Asia/Hong_Kong',

    'middlewares' => [
        Slimork\Middlewares\Route\DefaultMiddleware::class,
    ],

    'providers' => [
        Slimork\Providers\View\ViewServiceProvider::class
    ]
];
