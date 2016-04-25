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
 *      {{ tags | raw }}
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
        $this->container['csrf'] = function() {
            $settings = $this->container['settings']['app']['csrf'];

            $guard = new Csrf($settings['prefix']);
            $guard->setStrength($settings['strength']);

            return $guard;
        };
    }

    public function boot() {
        if ($this->container->has('flash') === true) {
            $this->container['csrf']->setFailureCallable(function(Request $request, Response $response, $next) {
                $this->container['session']->set('error', 'Failed CSRF check!');

                return $response->withStatus(302)->withHeader('Location', '/');
            });
        }

        if ($this->container['settings']['app']['csrf']['global'] === true) {
            $this->app->add($this->container['csrf']);
        }
    }

}
