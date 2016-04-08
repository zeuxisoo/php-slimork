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

    'timezone' => 'Asia/Hong_Kong',

    'providers' => [
        App\Providers\Eloquent\EloquentServiceProvider::class,
        App\Providers\View\ViewServiceProvider::class,
        App\Providers\Logger\LoggerServiceProvider::class,
        App\Providers\Hash\HashServiceProvider::class,
    ],

    'middleware' => [
        App\Middlewares\AppMiddleware::class,
    ]

];
