<?php
namespace App\Providers\Auth;

use App\Contracts\ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['auth'] = function($c) {
            return new Auth($c);
        };
    }

}
