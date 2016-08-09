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
        'name'     => '_sw',
        'lifetime' => 7200, // 2 hour
        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ],

    'jwt' => [
        'secret'      => 'bUKmIvL8KG]A5hp%dK%H%hOck.F-g,ir,ehhW(nhIFpDo^%A',
        'algorithm'   => 'HS256',
        'identifier'  => 'id',
        'ttl'         => 2880, // minutes, 2 days
    ],

    'translation' => [
        'default_locale'  => 'en_US',
        'fallback_locale' => ['en_US'],
    ],

    'timezone' => 'Asia/Hong_Kong',

    'providers' => [
        Simork\Providers\Session\SessionServiceProvider::class,
        Simork\Providers\Eloquent\EloquentServiceProvider::class,
        Simork\Providers\View\ViewServiceProvider::class,
        Simork\Providers\Logger\LoggerServiceProvider::class,
        Simork\Providers\Hash\HashServiceProvider::class,
        Simork\Providers\Flash\FlashServiceProvider::class,
        Simork\Providers\Csrf\CsrfServiceProvider::class,
        Simork\Providers\Validation\ValidatorServiceProvider::class,
        Simork\Providers\Fractal\FractalServiceProvider::class,
        Simork\Providers\Cookie\CookieServiceProvider::class,
        Simork\Providers\Auth\AuthServiceProvider::class,
        Simork\Providers\Jwt\JwtServiceProvider::class,
        Simork\Providers\Translation\TranslationServiceProvider::class,
    ],

    'middleware' => [
        App\Middlewares\AppMiddleware::class,
    ],

    'commands' => [
        Simork\Consoles\Commands\Serve::class,
    ]

];
