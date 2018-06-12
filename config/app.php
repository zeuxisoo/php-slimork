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
        Slimork\Providers\Session\SessionServiceProvider::class,
        Slimork\Providers\Cookie\CookieServiceProvider::class,
        Slimork\Providers\Flash\FlashServiceProvider::class,
        Slimork\Providers\Csrf\CsrfServiceProvider::class,
        Slimork\Providers\View\ViewServiceProvider::class,
        Slimork\Providers\Mail\MailServiceProvider::class,
        Slimork\Providers\Log\LogServiceProvider::class,
    ]
];
