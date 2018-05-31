<?php
namespace Slimork\Exceptions\Handlers;

use Slimork\Contracts\ExceptionHandler;

class NotFoundHandler extends ExceptionHandler {

    public function register() {
        $this->container->set('notFoundHandler', function ($c) {
            return function($request, $response) use ($c) {
                $content = render_error('404.html');

                return $response
                        ->withStatus(404)
                        ->withHeader('Content-Type', 'text/html')
                        ->write($content);
            };
        });
    }

}
