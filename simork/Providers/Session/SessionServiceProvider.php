<?php
namespace Simork\Providers\Session;

use Simork\Contracts\ServiceProvider;

class SessionServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['session'] = function($c) {
            return new Session($c);
        };
    }

    public function boot() {
        $this->app->add(new \Simork\Providers\Session\Middleware\Session($this->app));
    }

}
