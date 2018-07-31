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
        Slimork\Providers\Pagination\PaginationServiceProvider::class,
        Slimork\Providers\Database\DatabaseServiceProvider::class,
        Slimork\Providers\Flash\FlashServiceProvider::class,
        Slimork\Providers\Csrf\CsrfServiceProvider::class,
        Slimork\Providers\Validation\ValidationServiceProvider::class,
        Slimork\Providers\View\ViewServiceProvider::class,
        Slimork\Providers\Mail\MailServiceProvider::class,
        Slimork\Providers\Hash\HashServiceProvider::class,
        Slimork\Providers\Log\LogServiceProvider::class,
        Slimork\Providers\Redirection\RedirectionServiceProvider::class,
    ],

    'aliases' => [
        'App' => Slimork\Facades\App::class,
        'Container' => Slimork\Facades\Container::class,
        'Router' => Slimork\Facades\Router::class,
        'Request' => Slimork\Facades\Request::class,
        'Response' => Slimork\Facades\Response::class,
        'Settings' => Slimork\Facades\Settings::class,

        'Session' => Slimork\Facades\Session::class,
        'Cookie' => Slimork\Facades\Cookie::class,
        'Paginator' => Slimork\Facades\Paginator::class,
        'DB' => Slimork\Facades\Database::class,
        'Flash' => Slimork\Facades\Flash::class,
        'Csrf' => Slimork\Facades\Csrf::class,
        'Validator' => Slimork\Facades\Validator::class,
        'View' => Slimork\Facades\View::class,
        'Mail' => Slimork\Facades\Mail::class,
        'Hash' => Slimork\Facades\Hash::class,
        'Log' => Slimork\Facades\Log::class,
        'Redirect' => Slimork\Facades\Redirect::class,
    ],
];
