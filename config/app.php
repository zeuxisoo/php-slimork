<?php
return [

    'db' => [
        'default' => [
            'driver'    => 'sqlite',
            'host'      => 'localhost',
            'database'  => dirname(__DIR__).'/storage/database.sqlite',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        ]
    ],

    'csrf' => [
        'global'   => true,
        'prefix'   => 'csrf',
        'strength' => 16,
    ],

    'session' => [
        'name'     => '_s',
        'life_time' => 7200, // 2 hour
        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ],

    'timezone' => 'Asia/Hong_Kong',

    'providers' => [
        App\Providers\Session\SessionServiceProvider::class,
        App\Providers\Eloquent\EloquentServiceProvider::class,
        App\Providers\View\ViewServiceProvider::class,
        App\Providers\Logger\LoggerServiceProvider::class,
        App\Providers\Hash\HashServiceProvider::class,
        App\Providers\Flash\FlashServiceProvider::class,
        App\Providers\Csrf\CsrfServiceProvider::class,
        App\Providers\Validation\ValidatorServiceProvider::class,
        App\Providers\Fractal\FractalServiceProvider::class,
        App\Providers\Cookie\CookieServiceProvider::class,
        App\Providers\Auth\AuthServiceProvider::class,
    ],

    'middleware' => [
        App\Middlewares\SessionMiddleware::class,
        App\Middlewares\AppMiddleware::class,
    ],

];
