<?php
error_reporting(E_ALL);

// Define constant
define('BASE_ROOT', dirname(__DIR__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');
define('RESOURCE_ROOT', BASE_ROOT.'/resource');
define('STORAGE_ROOT', BASE_ROOT.'/storage');
define('APP_ROOT', BASE_ROOT.'/app');

// Composer auto loader
require_once VENDOR_ROOT.'/autoload.php';

// Import class
use Slimork\Foundation\App;

// Setup slim
$app      = new App();
$settings = $app->getContainer()->get('settings');

// Slim service providers
$providers = [];
foreach($settings['app']['providers'] as $provider) {
    $provider = new $provider($app);
    $provider->register();
    array_push($providers, $provider);
}

foreach($providers as $provider) {
    $provider->boot();
}

// Slim routes
require_once APP_ROOT.'/routes.php';

$app->run();
