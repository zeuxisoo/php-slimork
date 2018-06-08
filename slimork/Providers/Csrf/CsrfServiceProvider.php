<?php
namespace Slimork\Providers\Csrf;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Csrf
 *
 * Base pass token to view
 *
 *      # Controller
 *      $tags = $this->csrf->getTokenForHiddenInputTags();
 *      $tags = $this->csrf->getTokenForMetaTags();
 *
 *      # View
 *      {{ tags | raw }}
 *
 * Advanace (without controller, the view has global csrf, csrf_metas, csrf_tags variable)
 *
 *      {{ csrf }}
 *      <input type="hidden" name="{{csrf.keys.name}}" value="{{csrf.name}}">
 *      <input type="hidden" name="{{csrf.keys.value}}" value="{{csrf.value}}">
 *
 *      {{ csrf_metas }}
 *      <meta name='csrf_name' content='csrf_random_name' />
 *      <meta name='csrf_value' content='csrf_random_value' />
 *
 *      {{ csrf_tags }}
 *      <input type='hidden' name='csrf_name' value='csrf_random_name' />
 *      <input type='hidden' name='csrf_value' value='csrf_random_value' />
 *
 * Other pass token to view for custom
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
        $this->container->set('csrf', function($container) {
            $settings = $container->get('settings');
            $csrf     = $settings['csrf'];

            $guard = new Csrf($csrf['prefix']);
            $guard->setStrength($csrf['strength']);

            return $guard;
        });
    }

    public function boot() {
        $this->container->get('csrf')->setFailureCallable(function(Request $request, Response $response, $next) {
            $headers  = $request->getHeaders();
            $referers = array_key_exists('HTTP_REFERER', $headers) === true ? $headers['HTTP_REFERER'] : [];
            $referer  = empty($referers) === true ? '/' : current($referers);

            $content = render_error('400.csrf.html', compact('referer'));

            return $response
                    ->withStatus(400)
                    ->withHeader('Content-Type', 'text/html')
                    ->write($content);
        });

        //
        $settings = $this->container->get('settings');

        if ($settings['csrf']['global'] === true) {
            $this->app->add($this->container->get('csrf'));
        }

        //
        if ($this->container->has('view') === true) {
            $this->container->get('view')->addExtension(new ViewExtension($this->container));
        }
    }

}
