<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/',     'App\\Http\\Controllers\\HomeController:index')->name('index');
$app->get('/view', 'App\\Http\\Controllers\\HomeController:view')->name('view');
