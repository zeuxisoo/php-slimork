<?php
namespace Simork\Providers\Debugbar;

use Simork\Contracts\ServiceProvider;
use Simork\Providers\Debugbar\Middleware\Debugbar as DebugbarMiddleware;

/**
 * Usage
 * =====
 *
 * Debugbar
 *
 *      # In config/app.php
 *      'providers' => [
 *          ...
 *          Simork\Providers\Debugbar\DebugbarServiceProvider::class,
 *          ...
 *      ],
 */
class DebugbarServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['debugbar'] = function() {
            return new StandardDebugbar($this->app);
        };
    }

    public function boot() {
        $this->app->get('/_debugbar/resources/stylesheets', 'Simork\Providers\Debugbar\Controllers\AssetsController:css')->setName('debugbar.assets.css');
        $this->app->get('/_debugbar/resources/javascript', 'Simork\Providers\Debugbar\Controllers\AssetsController:js')->setName('debugbar.assets.js');

        $debugbar = $this->container['debugbar'];
        $debugbar->boot();

        $this->app->add(new DebugbarMiddleware($this->app));
    }

}
