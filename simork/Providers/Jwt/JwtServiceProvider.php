<?php
namespace Simork\Providers\Jwt;

use Simork\Contracts\ServiceProvider;

class JwtServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['jwt'] = function($c) {
            return new Jwt($c, $c['settings']['app']['jwt']);
        };
    }

}
