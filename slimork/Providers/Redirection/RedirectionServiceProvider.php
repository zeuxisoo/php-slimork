<?php
namespace Slimork\Providers\Redirection;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Redirection
 *
 *      # Redirect to path like / , /admin
 *      $this->redirect->to('path');
 *
 *      # Redirect to any url like https://google.com/
 *      $this->redirect->away('path');
 *
 *      # Redirect to route home.index
 *      $this->redirect->route('name');
 *
 *      # Redirect back to previous page
 *      $this->redirect->back();
 *
 *      # Redirect back to previous page with input data
 *      # - Controller
 *      $this->redirect->back()->withRequestParams();
 *      $this->redirect->back()->withRequestParams()->withHeader('X-Hello', 'Params included');
 *
 *      # - View
 *      {{ old_param(key, default = null) }}
 *
 *      # Redirect with flash message
 *      $this->redirect->{to,route,back}()->withError('message')
 *      $this->redirect->{to,route,back}()->withMessage('message')
 *      $this->redirect->{to,route,back}()->withTypeMessage('erorr|success', 'message')
 *
 */
class RedirectionServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('redirect', function($container) {
            return new Redirector($container);
        });
    }

    public function boot() {
        $this->app->add(new Middleware\Session($this->app));

        if ($this->container->has('view') === true) {
            $this->container->get('view')->addExtension(new ViewExtension($this->container));
        }
    }

}
