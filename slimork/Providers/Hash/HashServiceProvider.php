<?php
namespace Slimork\Providers\Hash;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Hash
 *
 *      echo $this->hash->make('string');
 *      echo $this->hash->check('string', 'hashed_string');
 *      echo $this->hash->needsRehash('hashed_string');
 */
class HashServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('hash', function($container) {
            return new HashManager($container);
        });
    }

}
