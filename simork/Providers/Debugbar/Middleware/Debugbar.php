<?php
namespace Simork\Providers\Debugbar\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\Body;

class Debugbar {

    protected $app;
    protected $container;

    public function __construct($app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next) {
        // Trigger and get response first
        $response = $next($request, $response);

        // Stop append debug bar when request is debug bar resource url
        if (preg_match("/\/_debugbar\/resources\/(stylesheets|javascript)/", $request->getUri()->getPath()) == true) {
            return $response;
        }

        $debug_bar      = $this->container->debugbar;
        $debug_bar_head = $debug_bar->getJavascriptRenderer()->renderHead();
        $debug_bar_body = $debug_bar->getJavascriptRenderer()->render();

        // Append debug bar to current page
        $response = $this->appendDebugBar($response, $debug_bar_head, $debug_bar_body);

        return $response;
    }

    public function appendDebugBar($response, $debug_bar_head, $debug_bar_body) {
        $page_body  = $response->getBody();
        $debug_bar = $debug_bar_head.$debug_bar_body;

        // Append debug bar to before body tag
        $html     = "";
        $position = mb_strripos($page_body, '</body>');

        if ($position === false) {
            $html = $page_body.$debug_bar;
        } else {
            $html = mb_substr($page_body, 0, $position).$debug_bar.mb_substr($page_body, $position);
        }

        // Reset response body
        $body = new Body(fopen('php://temp', 'r+'));
        $body->write($html);

        $response = new Response(200, null, $body);

        return $response;
    }

}
