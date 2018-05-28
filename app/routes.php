<?php
$app->get('/', function($request, $response) {
    return $response->write("Hello world");
});
