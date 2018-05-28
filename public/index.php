<?php
error_reporting(E_ALL);

define('VENDOR_ROOT', dirname(__DIR__).'/vendor');

require_once VENDOR_ROOT.'/autoload.php';

use Slim\App;

$app = new App();

$app->get('/', function($request, $response) {
    return $response->write("Hello world");
});

$app->run();
