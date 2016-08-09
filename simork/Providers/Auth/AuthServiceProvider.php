<?php
namespace Simork\Providers\Auth;

use Simork\Contracts\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['auth'] = function($c) {
            return new Auth($c);
        };
    }

}
