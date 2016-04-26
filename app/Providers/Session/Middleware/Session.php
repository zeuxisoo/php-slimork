<?php
namespace App\Providers\Session\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Session {

    public function __construct($app) {
        $container = $app->getContainer();

        if ($container->session->instance()->isStarted() === false) {
            $container->session->instance()->start();
        }
    }

    public function __invoke(Request $request, Response $response, $next) {
        return $next($request, $response);
    }

}
