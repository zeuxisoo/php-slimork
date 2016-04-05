<?php
error_reporting(E_ALL);
session_start();

// Define constant
define('BASE_ROOT', dirname(__DIR__));
define('VENDOR_ROOT', BASE_ROOT.'/vendor');
define('CONFIG_ROOT', BASE_ROOT.'/config');
define('RESOURCE_ROOT', BASE_ROOT.'/resource');
define('STORAGE_ROOT', BASE_ROOT.'/storage');

// Composer auto loader
require_once VENDOR_ROOT.'/autoload.php';

// Application configs
$config = [
    'app'  => require CONFIG_ROOT.'/app.php',
    'slim' => require CONFIG_ROOT.'/slim.php',
];

// Base configs
date_default_timezone_set($config['app']['timezone']);

// Import class
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Setup slim
$app = new App([
    'settings' => $config['slim']
]);

// Slim container
$container = $app->getContainer();

// Slim view
$container['view'] = function($c) {
    $base_path = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

    $view = new Twig(RESOURCE_ROOT.'/view', [
        'charset'          => 'utf-8',
        'cache'            => STORAGE_ROOT.'/cache/view',
        'auto_reload'      => true,
        'strict_variables' => false,
        'autoescape'       => true
    ]);

    $view->addExtension(new TwigExtension($c['router'], $base_path));

    return $view;
};

// Slim logger
$container['logger'] = function($c) {
    $logger       = new Logger('SIMPLE_WORK');
    $file_handler = new StreamHandler(STORAGE_ROOT.'/logs/'.date('Y-m-d').'.log');

    $logger->pushHandler($file_handler);

    return $logger;
};

$app->get('/', function ($request, $response, $args) {
    $this->logger->addInfo('called index handler');

    return $this->view->render($response, 'index.html');
})->setName('index');

$app->run();
