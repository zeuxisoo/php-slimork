<?php
namespace App\Providers\Debugbar;

use App\Contracts\ServiceProvider;
use App\Providers\Debugbar\Middleware\Debugbar as DebugbarMiddleware;

/**
 * Usage
 * =====
 *
 * Debugbar
 *
 *      # In config/app.php
 *      'providers' => [
 *          ...
 *          App\Providers\Debugbar\DebugbarServiceProvider::class,
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
        $this->app->get('/_debugbar/resources/stylesheets', 'App\Providers\Debugbar\Controllers\AssetsController:css')->setName('debugbar.assets.css');
        $this->app->get('/_debugbar/resources/javascript', 'App\Providers\Debugbar\Controllers\AssetsController:js')->setName('debugbar.assets.js');

        $debugbar = $this->container['debugbar'];
        $debugbar->boot();

        $this->app->add(new DebugbarMiddleware($this->app));
    }

}
