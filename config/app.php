<?php
return [

    'db' => [
        'default' => [
            'driver'    => 'sqlite',
            'host'      => 'localhost',
            'database'  => STORAGE_ROOT.'/database.sqlite',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => ''
        ]
    ],

    'timezone' => 'Asia/Hong_Kong',

    'providers' => [
        App\Providers\EloquentServiceProvider::class,
        App\Providers\ViewServiceProvider::class,
        App\Providers\LoggerServiceProvider::class,
        App\Providers\HashServiceProvider::class,
    ],

    'middleware' => [
        App\Middlewares\AppMiddleware::class,
    ]

];
