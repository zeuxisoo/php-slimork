<?php
namespace App\Providers\Debugbar;

use DebugBar\StandardDebugBar as BaseStandardDebugbar;
use App\Providers\Debugbar\DataCollector\QueryCollector;

class StandardDebugbar extends BaseStandardDebugbar {

    protected $app;

    public function __construct($app) {
        parent::__construct();

        $this->app = $app;
    }

    public function boot() {
        $this->addQueryCollector();

        $this->getJavascriptRenderer();
    }

    protected function addQueryCollector() {
        $time_collector  = $this->getCollector('time');
        $query_collector = new QueryCollector($time_collector);

        $this->addCollector($query_collector);

        $database   = $this->app->getContainer()->get('db');
        $connection = $database->getConnection();

        $connection->listen(function($query, $bindings = null, $time = null, $connection_name = null) use ($database, $query_collector) {
            if ($query instanceof \Illuminate\Database\Events\QueryExecuted ) {
                $sql        = $query->sql;
                $bindings   = $query->bindings;
                $time       = $query->time;

                $connection = $query->connection;
            }else{
                $connection = $database->connection($connection_name);
            }

            $query_collector->addQuery((string) $sql, $bindings, $time, $connection);
        });
    }

    public function getJavascriptRenderer($base_url = null, $base_path = null) {
        if ($this->jsRenderer === null) {
            $this->jsRenderer = new JavascriptRenderer($this, $base_url, $base_path);
            $this->jsRenderer->setApp($this->app);
        }
        return $this->jsRenderer;
    }


}
