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
 *
 *  Other:
 *
 *      # Return the first row like { total: 1 }
 *      $this->db->fetchOneRaw("SELECT COUNT(*) AS total FROM table");
 *
 */
class DatabaseServiceProvider extends ServiceProvider {

    public function register() {
        // Setup capsule manager
        $settings = $this->container->get('settings');

        //
        $capsule  = new DatabaseManager;
        $capsule->setDefaultConnection($settings['database']['default']);

        foreach($settings['database']['connections'] as $name => $database) {
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
        if ($this->container->has('paginator') === false) {
            $settings = $this->container->get('settings');
            $request  = $this->container->get('request');

            // Get current url and page no
            $query_pairs = [];

            parse_str($request->getUri()->getQuery(), $query_pairs);

            if (array_key_exists('page', $query_pairs) === true) {
                unset($query_pairs['page']);
            }

            $query_string = http_build_query($query_pairs);
            $current_url  = (string) $request->getUri()->withQuery($query_string);
            $current_page = $request->getParam('page');

            // Get template name
            $default_template = empty($settings['pagination']['views']['default']) === false ? $settings['pagination']['views']['default'] : 'default.html';
            $simple_template  = empty($settings['pagination']['views']['simple']) === false ? $settings['pagination']['views']['simple'] : 'default.simple.html';

            // Get paginator view object
            $pagiantor_view = empty($settings['pagination']['paginator']) === false ? $settings['pagination']['paginator'] : PaginatorView::class;

            // Setup paginator template
            Paginator::defaultView($default_template);
            Paginator::defaultSimpleView($simple_template);

            // Setup paginator resolver
            Paginator::viewFactoryResolver(function() use ($pagiantor_view) {
                return new $pagiantor_view($this->container);
            });

            Paginator::currentPathResolver(function () use ($current_url) {
                return $current_url;
            });

            Paginator::currentPageResolver(function() use ($current_page) {
                return $current_page;
            });
        }
    }

}
