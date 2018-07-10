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

    'pagination' => [
        'resolver' => [
            'view' => Slimork\Providers\Database\DefaultPaginatorView::class,
        ],
        'view' => [
            'default' => 'pagination::default',
            'simple'  => 'pagination::default.simple'
        ]
    ]
];
