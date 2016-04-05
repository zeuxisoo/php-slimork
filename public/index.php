<?php
require_once dirname(__DIR__).'/vendor/autoload.php';

$app = new Slim\App();

$app->get('/', function ($request, $response, $args) {
    $response->write("Hello, It's work");

    return $response;
});

$app->run();
