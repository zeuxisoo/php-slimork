<?php
namespace Slimork\Exceptions\Handlers;

use Slimork\Contracts\ExceptionHandler;

class ErrorHandler extends ExceptionHandler {

    public function register() {
        $settings = $this->container->get('settings');

        if ($settings['displayErrorDetails'] === false) {
            $this->container->set('errorHandler', function($c) {
                return function($request, $response, $exception) use ($c) {
                    // Write to log file
                    if ($c->has('log') === true) {
                        $c->get('log')->error($exception);
                    }

                    // Render error page
                    $content = render_error('500.html');

                    return $response
                            ->withStatus(500)
                            ->withHeader('Content-Type', 'text/html')
                            ->write($content);
                };
            });
        }
    }

}
