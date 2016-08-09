<?php
namespace Simork\Providers\Fractal;

use Simork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Fractal:
 *
 *      use Simork\Models\User;
 *      use Simork\Transformers\UserTransformer;
 *
 *      # Get fractal service
 *      $fractal = $this->fractal;
 *
 *      # Collection
 *      $users      = User::get();
 *      $collection = $fractal->collection($users, new UserTransformer);
 *
 *      $collection->toArray();
 *      $collection->toJson();
 *
 *      # Item
 *      $user = User::find(1);
 *      $item = $fractal->item($user, new UserTransformer);
 *
 *      $item->toArray();
 *      $item->toJson();
 */
class FractalServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['fractal'] = function() {
            return new Fractal();
        };
    }

}
