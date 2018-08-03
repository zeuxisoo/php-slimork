<?php
namespace Slimork\Facades;

use Illuminate\Database\Capsule\Manager as Capsule;

class Schema extends Facade {

    public static function getFacadeAccessor() {
        return Capsule::schema();
    }

}
