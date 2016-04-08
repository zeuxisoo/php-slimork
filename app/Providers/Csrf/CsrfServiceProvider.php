<?php
namespace App\Providers\Csrf;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Csrf
 *
 * Base
 *
 *      # Controller
 *      $tags = $this->csrf->getTokenForHiddenInputTags();
 *      $tags = $this->csrf->getTokenForMetaTags();
 *
 *      # View
 *      {{ $tags | raw }}
 *
 * Custom
 *
 *      # Controller
 *      $csrf_tokens = $this->csrf->getTokens();
 *
 *      # View
 *      {% for name, value in csrf_tokens %}
 *          <input type="hidden" name="{{ name }}" value="{{ value }}">
 *      {% endfor %}
 *
 *      {% for name, value in csrf_tokens %}
 *          <meta name="{{ name }}" content="{{ value }}">
 *      {% endfor %}
 */
class CsrfServiceProvider extends ServiceProvider {

    public function register() {
        $container     = $this->container;
        $csrf_settings = $container->settings['app']['csrf'];

        // Setup CSRF and container
        $guard = new Csrf($csrf_settings['prefix']);
        $guard->setStrength($csrf_settings['strength']);

        if ($container->has('flash') === true) {
            $guard->setFailureCallable(function(Request $request, Response $response, $next) use ($container) {
                $container->flash->error('Failed CSRF check!');

                return $response->withStatus(302)->withHeader('Location', '/');
            });
        }

        $container['csrf'] = function() use ($guard) {
            return $guard;
        };

        // Add to application level middleware if global is true
        if ($container->settings['app']['csrf']['global'] === true) {
            $this->app->add($guard);
        }
    }

}
