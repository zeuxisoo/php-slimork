<?php
namespace App\Providers\Jwt;

use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Jwt:
 *
 *
 */
class JwtServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['jwt'] = function($c) {
            return new Jwt($c, $c['settings']['app']['jwt']);
        };
    }

}
