<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Usage
 * =====
 *
 * Auth
 *
 *      use App\Middlewares\AuthMiddleware;
 *
 *      $auth_middleware = new AuthMiddleware($app);
 *
 *      $app->get('/auth', function($request, $resposne, $args) {
 *          return $resposne->write('Logged in');
 *      })->add($auth_middleware);
 */
class AuthMiddleware {

    protected $app;
    protected $container;

    public function __construct($app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    public function __invoke(Request $request, Response $response, $next) {
        if ($this->container->auth->guest() === true) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }

        return $next($request, $response);
    }

}
