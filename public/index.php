<?php
error_reporting(E_ALL);

// Define constant
define('BASE_ROOT', dirname(__DIR__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');
define('RESOURCES_ROOT', BASE_ROOT.'/resources');
define('STORAGE_ROOT', BASE_ROOT.'/storage');
define('APP_ROOT', BASE_ROOT.'/app');

// Composer auto loader
require_once VENDOR_ROOT.'/autoload.php';

// Import class
use Slimork\Foundation\App;

// Setup slim
$app = new App();
$app->loadBaseBootstrappers();
$app->loadAppCore();
$app->loadBuiltInBootstrappers();
$app->loadRoutes();
$app->run();
