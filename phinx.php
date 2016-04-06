<?php
// Define constant
define('BASE_ROOT', dirname(__FILE__));

// Import class
use Illuminate\Database\Capsule\Manager as Capsule;

// Application config
$config = require BASE_ROOT.'/config/app.php';

// Base config
date_default_timezone_set($config['timezone']);

// Setup database
$capsule = new Capsule;

foreach($config['db'] as $name => $database) {
    $capsule->addConnection($database, $name);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Return settings for phinx
return [
    'paths' => [
        'migrations' => BASE_ROOT.'/database/migrations',
        'seeds'      => BASE_ROOT.'/database/seeds'
    ],

    'migration_base_class' => App\Contracts\Migration::class,

    'environments' => [
        'default_migration_table' => 'phinx_log',

        'default_database' => 'default',

        'default' => [
            'connection' => $capsule->getConnection()->getPdo(),
            'name'       => $config['db']['default']['database'],
        ]
    ],
];
