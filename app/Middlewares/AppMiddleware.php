<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AppMiddleware {

    protected $app;
    protected $container;

    public function __construct($app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    public function __invoke(Request $request, Response $response, $next) {
        return $next($request, $response);
    }

}
