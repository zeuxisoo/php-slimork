<?php
namespace Simork\Providers\Cookie;

use Simork\Contracts\ServiceProvider;

class CookieServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['cookie'] = function($c) {
            return new Cookie($c);
        };
    }

}
