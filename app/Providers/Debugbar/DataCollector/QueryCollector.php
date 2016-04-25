<?php
namespace App\Providers\Debugbar\DataCollector;

use DebugBar\DataCollector\PDO\PDOCollector;
use DebugBar\DataCollector\TimeDataCollector;

class QueryCollector extends PDOCollector {

    protected $queries = [];

    protected $time_collector;

    public function __construct(TimeDataCollector $time_collector = null) {
        $this->time_collector = $time_collector;
    }

    public function addQuery($sql, $bindings, $time, $connection) {
        $time       = $time / 1000;
        $end_time   = microtime(true);
        $start_time = $end_time - $time;

        $pdo      = $connection->getPdo();
        $bindings = $connection->prepareBindings($bindings);

        $bindings = $this->checkBindings($bindings);

        if (empty($bindings) === false) {
            foreach ($bindings as $binding) {
                $sql = preg_replace('/\?/', $pdo->quote($binding), $sql, 1);
            }
        }

        $this->queries[] = array(
            'sql'        => $sql,
            'bindings'   => $this->escapeBindings($bindings),
            'time'       => $time,
            'connection' => $connection->getDatabaseName(),
        );

        if ($this->timeCollector !== null) {
            $this->timeCollector->addMeasure($sql, $start_time, $end_time);
        }
    }

    protected function checkBindings($bindings) {
        foreach ($bindings as $binding) {
            if (is_string($binding) === true && mb_check_encoding($binding, 'UTF-8') === false) {
                $binding = '[BINARY DATA]';
            }
        }

        return $bindings;
    }

    protected function escapeBindings($bindings) {
        foreach ($bindings as $binding) {
            $binding = htmlentities($binding, ENT_QUOTES, 'UTF-8', false);
        }

        return $bindings;
    }

    protected function formatSql($sql) {
        return trim(preg_replace("/\s*\n\s*/", "\n", $sql));
    }

    // @overwrite
    public function collect() {
        $total_time = 0;
        $queries    = $this->queries;
        $statements = [];

        foreach ($queries as $query) {
            $total_time += $query['time'];

            $statements[] = array(
                'sql'          => $this->formatSql($query['sql']),
                'params'       => (object) $query['bindings'],
                'duration'     => $query['time'],
                'duration_str' => $this->formatDuration($query['time']),
                'connection'   => $query['connection'],
            );
        }

        $data = array(
            'nb_statements'            => count($queries),
            'nb_failed_statements'     => 0,
            'accumulated_duration'     => $total_time,
            'accumulated_duration_str' => $this->formatDuration($total_time),
            'statements'               => $statements
        );

        return $data;
    }

}
