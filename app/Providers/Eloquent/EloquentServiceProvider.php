<?php
namespace App\Providers\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;
use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Query:
 *
 *      # Default connection
 *      $user = $this->db->table('user')->find(1);
 *
 *      # Other connection
 *      $this->db->getConnection('connection')->table('user')->find(1)
 *
 * Model:
 *
 *      $user = User::find(1);
 *      $user = User::on('connection')->find(1);
 *
 * Paginate:
 *
 *      $user = User::paginate(1);
 *
 *      echo $paginate->render();
 */
class EloquentServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['db'] = function($c) {
            $settings = $c['settings'];
            $capsule  = new Capsule;

            foreach($settings['app']['db'] as $name => $database) {
                $capsule->addConnection($database, $name);
            }

            $capsule->setAsGlobal();
            $capsule->bootEloquent();

            return $capsule;
        };
    }

}
