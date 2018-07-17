<?php
namespace Slimork\Providers\Session\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slimork\Contracts\Middleware;

class Session extends Middleware {

    protected $session;

    public function __construct($app) {
        parent::__construct($app);

        $session = $this->container->get('session');

        if ($session->isStarted() === false) {
            $session->start();
        }

        $this->session = $session;
    }

    public function __invoke(Request $request, Response $response, $next) {
        return $next($request, $response);
    }

}
