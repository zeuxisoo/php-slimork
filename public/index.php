<?php
error_reporting(E_ALL);

// Define constant
define('BASE_ROOT', dirname(__DIR__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');
define('RESOURCE_ROOT', BASE_ROOT.'/resource');
define('STORAGE_ROOT', BASE_ROOT.'/storage');
define('APP_ROOT', BASE_ROOT.'/app');
define('LANG_ROOT', RESOURCE_ROOT.'/lang');

// Composer auto loader
require_once VENDOR_ROOT.'/autoload.php';

// Application configs
$settings = [];
foreach(glob(CONFIG_ROOT."/*") as $file_path) {
    $file_name = basename($file_path, ".php");

    if ($file_name !== 'slim') {
        $settings[$file_name] = require_once $file_path;
    }
}

$settings = array_merge(require CONFIG_ROOT.'/slim.php', $settings);

// Base configs
date_default_timezone_set($settings['app']['timezone']);

// Import class
use Slim\App;

// Setup slim
$app = new App([
    'settings' => $settings
]);

// Slim middlewares (application level)
foreach($settings['app']['middleware'] as $middleware) {
    $app->add(new $middleware($app));
}

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
