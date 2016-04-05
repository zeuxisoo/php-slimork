<?php
namespace App\Middlewares;

use App\Contracts\Middleware;

class AppMiddleware extends Middleware {

    public function __invoke($request, $response, $next) {
        return $next($request, $response);
    }

}
