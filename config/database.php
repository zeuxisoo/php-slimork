<?php
return [
    'default' => 'mysql',

    'connections' => [
        'mysql' => [
            'driver'    => 'mysql',
            'host'      => 'mysqldb',   // IP or Host name or Docker service name
            'database'  => 'slimork',
            'username'  => 'slimork',
            'password'  => '12345678',
            'charset'   => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix'    => 'sw_',
            'engine'    => 'MyISAM',    // MySQL Only
        ],

        'sqlite' => [
            'driver'    => 'sqlite',
            'host'      => 'localhost',
            'database'  => dirname(__DIR__).'/storage/database.sqlite',
            'username'  => 'root',
            'password'  => '',
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
