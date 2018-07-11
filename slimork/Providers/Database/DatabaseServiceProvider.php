<?php
namespace Slimork\Providers\Database;

use Illuminate\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Database:
 *
 *  Query:
 *
 *      # Default connection
 *      $user = $this->db->table('user')->find(1);
 *
 *      # Other connection
 *      $this->db->getConnection('connection')->table('user')->find(1)
 *
 *  Model:
 *
 *      $user = User::find(1);
 *      $user = User::on('connection')->find(1);
 *
 *  Paginate:
 *
 *      $user = User::paginate(1);
 *
 *      echo $paginate->render();
 */
class DatabaseServiceProvider extends ServiceProvider {

    public function register() {
        // Setup capsule manager
        $settings = $this->container->get('settings');
        $capsule  = new DatabaseManager;

        foreach($settings['database'] as $name => $database) {
            $capsule->addConnection($database, $name);
        }

        $capsule->setAsGlobal();
        $capsule->setEventDispatcher(new Dispatcher());
        $capsule->bootEloquent();

        // Setup db service provider
        $this->container->set('db', function() use ($capsule) {
            return $capsule;
        });

        $this->container->set('db.connection', function() use ($capsule) {
            return $capsule->getConnection();
        });
    }

}
