<?php
namespace Slimork\Providers\Database;

use Illuminate\Database\Capsule\Manager as CapsuleManager;

class DatabaseManager extends CapsuleManager {

    public function __call($method, $arguments) {
        return $this->getConnection()->$method(...$arguments);
    }

}
