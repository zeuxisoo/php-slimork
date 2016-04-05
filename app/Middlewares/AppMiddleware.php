<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\Middleware;

class AppMiddleware extends Middleware {

    public function __invoke(Request $request, Response $response, $next) {
        return $next($request, $response);
    }

}
