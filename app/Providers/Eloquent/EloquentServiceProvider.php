<?php
namespace App\Providers\Eloquent;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Pagination\Paginator;
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
        // Setup capsule manager
        $settings = $this->container->settings;
        $capsule  = new Capsule;

        foreach($settings['app']['db'] as $name => $database) {
            $capsule->addConnection($database, $name);
        }

        $capsule->setAsGlobal();
        $capsule->setEventDispatcher(new Dispatcher());
        $capsule->bootEloquent();

        // Setup db service provider
        $this->container['db'] = function() use ($capsule) {
            return $capsule;
        };
    }

    public function boot() {
        $request      = $this->container->request;
        $current_page = $request->getParam('page');

        Paginator::currentPageResolver(function() use ($current_page) {
            return $current_page;
        });
    }

}
