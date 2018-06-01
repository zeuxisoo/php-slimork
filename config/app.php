<?php
return [
    'timezone' => 'Asia/Hong_Kong',

    'middlewares' => [
        Slimork\Middlewares\Route\DefaultMiddleware::class,
    ],

    'handlers' => [
        Slimork\Exceptions\Handlers\NotFoundHandler::class,
        Slimork\Exceptions\Handlers\NotAllowedHandler::class,
        Slimork\Exceptions\Handlers\ErrorHandler::class,
        Slimork\Exceptions\Handlers\PhpErrorHandler::class,
    ],

    'providers' => [
        Slimork\Providers\View\ViewServiceProvider::class,
        Slimork\Providers\Log\LogServiceProvider::class,
    ]
];
