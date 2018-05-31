<?php
namespace Slimork\Middlewares\Route;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slimork\Contracts\Middleware;

/**
 * Usage
 * =====
 *
 * DefaultMiddleware:
 *
 *      $middlewares = [
 *          Slimork\Middlewares\Route\DefaultMiddleware::class,
 *      ]
 *
 */
class DefaultMiddleware extends Middleware {

    public function __invoke(Request $request, Response $response, $next) {
        return $next($request, $response);
    }

}

