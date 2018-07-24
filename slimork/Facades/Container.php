<?php
namespace Slimork\Facades;

class Container extends Facade {

    protected static function findFacadeInstance($name) {
        if (isset(static::$fadeInstances[$name]) === true) {
            return static::$fadeInstances[$name];
        }

        static::$fadeInstances[$name] = static::$app->getContainer();

        return static::$fadeInstances[$name];
    }

    public static function getFacadeAccessor() {
        return 'container';
    }

}
