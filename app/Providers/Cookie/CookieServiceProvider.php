<?php
namespace App\Providers\Cookie;

use App\Contracts\ServiceProvider;

class CookieServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['cookie'] = function($c) {
            return new Cookie($c);
        };
    }

}
