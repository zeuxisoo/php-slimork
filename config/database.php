<?php
return [
    'default' => [
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

    'migration' => [
        'table' => 'migrations',
    ]
];
