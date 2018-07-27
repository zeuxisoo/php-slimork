<?php
namespace Slimork\Providers\Database;

use Illuminate\Database\Capsule\Manager as CapsuleManager;

class DatabaseManager extends CapsuleManager {

    // Select in raw sql statement and only return first row like
    public function fetchOneRaw($sql) {
        $connection = $this->getConnection();

        return collect($connection->select(
            $connection->raw($sql)
        ))->first();
    }

    public function __call($method, $arguments) {
        return $this->getConnection()->$method(...$arguments);
    }

}
