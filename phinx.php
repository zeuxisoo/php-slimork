<?php
define('BASE_ROOT', dirname(__FILE__));

// Import
use Illuminate\Database\Capsule\Manager as Capsule;

// Config
$config = [
    'app'      => require BASE_ROOT.'/config/app.php',
    'database' => require BASE_ROOT.'/config/database.php'
];

// Initial
date_default_timezone_set($config['app']['timezone']);

// Database
$capsule = new Capsule;

foreach($config['database'] as $name => $database) {
    $capsule->addConnection($database, $name);
}

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Return
return [
    'paths' => [
        'migrations' => BASE_ROOT.'/database/migrations',
        'seeds'      => BASE_ROOT.'/database/seeds'
    ],
    'migration_base_class' => Simork\Contracts\Migration::class,
    'environments' => [
        'default_migration_table' => $config['database']['default']['prefix'].$config['database']['migration']['table'],
        'default_database' => 'default',
        'default' => [
            'connection'   => $capsule->getConnection()->getPdo(),
            'name'         => $config['database']['default']['database'],
            'table_prefix' => $config['database']['default']['prefix']
        ]
    ],
];
