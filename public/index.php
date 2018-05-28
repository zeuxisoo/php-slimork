<?php
error_reporting(E_ALL);

// Define constant
define('BASE_ROOT', dirname(__DIR__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');

// Composer auto loader
require_once VENDOR_ROOT.'/autoload.php';

// Application configs
$settings = [];
foreach(glob(CONFIG_ROOT."/*.php") as $file_path) {
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

$app->get('/', function($request, $response) {
    print_r($this->settings);
    return $response->write("Hello world");
});

$app->run();
