<?php
namespace Slimork\Providers\Redirection\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slimork\Contracts\Middleware;

class Session extends Middleware {

    protected $redirect;

    public function __construct($app) {
        parent::__construct($app);

        $this->redirect = $this->container->get('redirect');
    }

    public function __invoke(Request $request, Response $response, $next) {
        $current_route = $request->getUri()->getPath();
        $current_url   = (string) $request->getUri();

        if ($request->isGet() === true && is_string($current_route) === true && $request->isXhr() === false) {
            $this->redirect->setPreviousUrl($current_url);
        }

        return $next($request, $response);
    }

}
