<?php
namespace App\Providers\Hash;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Contracts\ServiceProvider;
use App\Helpers\BcryptHelper;

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
        $this->container['hash'] = function() {
            return new BcryptHelper();
        };
    }

}
