<?php
namespace Slimork\Providers\Cookie;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Cookie:
 *
 *      # Set cookie
 *      $this->cookie->set('name', 'value');
 *      $this->cookie->set('name', 'value', [option]);
 *
 *      # Get cookie
 *      $this->cookie->get('name');
 *
 *      # Remove cookie
 *      $this->cookie->remove('name');
 *
 *      # Is value exists or not
 *      $this->cookie->has('name');
 */
class CookieServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('cookie', function($container) {
            return new Cookie($container);
        });
    }

}
