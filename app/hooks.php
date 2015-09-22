<?php
if (defined("IN_APPS") === false) exit("Access Dead");

$app->hook('slim.before', function() {

});

$app->hook('slim.before.dispatch', function() {

});

$app->hook('slim.after.dispatch', function() {

});

$app->notfound(function() use ($app) {
    $home_url = $app->request->getRootUri();

    if ($app->request->isAjax() === true) {
        $response = $app->response();
        $response->status(404);
        $response['Content-Type'] = 'application/json';
        $response->write(json_encode(array(
            'message' => "Not found"
        )));
        $app->stop();
    }else{
        $app->render('error/404.html', compact('home_url'));
    }
});
