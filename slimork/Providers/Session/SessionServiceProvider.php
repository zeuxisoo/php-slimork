<?php
namespace Slimork\Providers\Session;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Session:
 *
 *      # Set key and value
 *      $this->session->set('key', 'value')
 *
 *      # Get value
 *      $this->session->get('key')
 *
 *      # Is value exists or not
 *      $this->session->has('key2')
 *
 *      # Remove value
 *      $this->session->remove('key')
 *
 *      # Pop value
 *      $this->session->pop('key');
 *
 *      # Push value to array item (the key must not exists)
 *      $this->session->push('key3', 'a'); // ['a']
 *      $this->session->push('key3', 'b'); // ['a', 'b']
 *      $this->session->push('key3', 'c'); // ['a', 'b', 'c']
 *
 *      # Pull value from array item
 *      $this->session->pull('key3'); // c
 *      $this->session->pull('key3'); // b
 *      $this->session->pull('key3'); // a
 */
class SessionServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('session', function($container) {
            return new Session($container);
        });
    }

}
