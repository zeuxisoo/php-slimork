<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->get('/', function() use ($app) {
    echo "<h3>Normal</h3>";
    echo "<p>It is work</p>";

    echo "<h3>Translator</h3>";
    echo "<p>".$app->locale->trans("It is work, %name%", array('%name%' => 'test'))."</p>";

    echo "<h3>Translator with view</h3>";
    echo "<a href='".$app->urlFor('view')."'>See view render</a>";
})->name('index');

$app->get('/view', function() use ($app) {
    $app->render('view.html');
})->name('view');
