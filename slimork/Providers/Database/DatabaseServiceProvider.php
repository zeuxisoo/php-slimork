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

    public function boot() {
        // Get container object
        $view     = $this->container->get('view');
        $request  = $this->container->get('request');

        // Get current full url but without &page=xx / ?page=xx keyword
        $query_pairs = [];

        parse_str($request->getUri()->getQuery(), $query_pairs);

        if (array_key_exists('page', $query_pairs) === true) {
            unset($query_pairs['page']);
        }

        $query_string = http_build_query($query_pairs);
        $current_url  = (string) $request->getUri()->withQuery($query_string);

        // Get current page no
        $current_page = $request->getParam('page');

        // Setup paginator
        Paginator::defaultView('pagination::default');
        Paginator::defaultSimpleView('pagination::default.simple');

        Paginator::viewFactoryResolver(function() {
            return new PaginatorView($this->container);
        });

        Paginator::currentPathResolver(function () use ($current_url) {
            return $current_url;
        });

        Paginator::currentPageResolver(function() use ($current_page) {
            return $current_page;
        });
    }

}
