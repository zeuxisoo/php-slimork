<?php
namespace Slimork\Providers\Hash;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Hash
 *
 * Base Usage
 *
 *      $this->hash->make('string');
 *      $this->hash->check('string', 'hashed_string');
 *      $this->hash->needsRehash('hashed_string');
 *
 * Overwrite default bcrypt options
 *
 *      $this->hash->make('string', ['cost' => 10]);
 *      $this->hash->needsRehash('hashed_string', ['cost' => 10]);
 *
 * Overwrite default argon2 options
 *
 *      $this->hash->make('string', [
 *          'memory_cost' => 2046,
 *          'threads'     => 4,
 *          'time_cost'   => 4,
 *      ]);
 *
 *      $this->hash->needsRehash('hashed_string', [
 *          'memory_cost' => 2046,
 *          'threads'     => 4,
 *          'time_cost'   => 4,
 *      ]);
 *
 */
class HashServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('hash', function($container) {
            return new HashManager($container);
        });
    }

}
