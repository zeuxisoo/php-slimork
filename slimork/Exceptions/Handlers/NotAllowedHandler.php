<?php
namespace Slimork\Exceptions\Handlers;

use Slimork\Contracts\ExceptionHandler;

class NotAllowedHandler extends ExceptionHandler {

    public function register() {
        $this->container->set('notAllowedHandler', function($c) {
            return function($request, $response, $methods) use ($c) {
                $content = render_error('405.html');

                return $response
                        ->withStatus(405)
                        ->withHeader('Allow', implode(', ', $methods))
                        ->withHeader('Content-Type', 'text/html')
                        ->write($content);
            };
        });
    }

}
