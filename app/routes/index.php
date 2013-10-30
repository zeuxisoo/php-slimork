<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/', function() use ($app) {
    echo "It is work";
});
