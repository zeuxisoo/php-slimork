<?php
return [
    'timezone' => 'Asia/Hong_Kong',

    'middlewares' => [
        Slimork\Middlewares\Route\DefaultMiddleware::class,
    ],

    'handlers' => [
        Slimork\Exceptions\Handlers\NotFoundHandler::class,
        Slimork\Exceptions\Handlers\NotAllowedHandler::class,
    ],

    'providers' => [
        Slimork\Providers\View\ViewServiceProvider::class
    ]
];
