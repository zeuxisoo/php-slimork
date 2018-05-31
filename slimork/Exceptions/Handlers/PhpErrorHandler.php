<?php
namespace Slimork\Exceptions\Handlers;

use Slimork\Contracts\ExceptionHandler;

class PhpErrorHandler extends ExceptionHandler {

    public function register() {
        $settings = $this->container->get('settings');

        if ($settings['displayErrorDetails'] === false) {
            $this->container->set('phpErrorHandler', function($c) {
                return function($request, $response, $error) use ($c) {
                    // Write to log file
                    if ($c->has('log') === true) {
                        $c->get('log')->error($error);
                    }

                    // Render error page
                    $content = render_error('500.php.html');

                    return $response
                            ->withStatus(500)
                            ->withHeader('Content-Type', 'text/html')
                            ->write($content);
                };
            });
        }
    }

}
