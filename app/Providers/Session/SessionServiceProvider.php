<?php
namespace App\Providers\Session;

use App\Contracts\ServiceProvider;

class SessionServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['session'] = function() {
            return new Session();
        };
    }

    public function boot() {
        $this->app->add(new \App\Providers\Session\Middleware\Session($this->app));
    }

}
