<?php
return [
    'default' => env('DB_CONNECTION', 'mysql'),

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => env('DB_HOST', 'mysqldb'),   // IP or Host name or Docker service name
            'database'  => env('DB_DATABASE', 'slimork'),
            'username'  => env('DB_USERNAME', 'slimork'),
            'password'  => env('DB_PASSWORD', '12345678'),
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => 'sw_',
            'engine'    => 'MyISAM',    // MySQL Only
        ],

        'sqlite' => [
            'driver'    => 'sqlite',
            'host'      => env('DB_HOST', 'sqlite'),
            'database'  => env('DB_DATABASE', dirname(__DIR__).'/storage/database.sqlite'),
            'username'  => env('DB_USERNAME', 'slimork'),
            'password'  => env('DB_PASSWORD', '12345678'),
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => 'sw_',
            'engine'    => 'MyISAM',    // MySQL Only
        ],
    ],

    'migration' => [
        'table' => 'migrations',
    ]
];
