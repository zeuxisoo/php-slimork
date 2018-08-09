<?php
namespace Slimork\Providers\Database;

use Illuminate\Database\Capsule\Manager as CapsuleManager;

class DatabaseManager extends CapsuleManager {

    // Replace the parent default connection name
    public function setDefaultConnection($name) {
        $this->container['config']['database.default'] = $name;
    }

    // Select in raw sql statement and only return first row like
    public function fetchOneRaw($sql) {
        $connection = $this->getConnection();

        return collect($connection->select(
            $connection->raw($sql)
        ))->first();
    }

    //
    public function __call($method, $arguments) {
        // dd('abc');
        return $this->getConnection()->$method(...$arguments);
    }

}
