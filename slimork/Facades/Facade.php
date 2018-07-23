<?php
namespace Slimork\Facades;

/**
 * Usage
 * =====
 *
 * Facade:
 *
 *     Facade::setFacadeApplication($app);
 */
abstract class Facade {

    protected static $app;
    protected static $fadeInstances;

    public static function setFacadeApplication($app) {
        static::$app = $app;
    }

    public static function getFacadeApplication() {
        return static::$app;
    }

    public static function getFacadeRoot() {
        return static::findFacadeInstance(static::getFacadeAccessor());
    }

    protected static function findFacadeInstance($name) {
        if (is_object($name) === true) {
            return $name;
        }

        if (isset(static::$fadeInstances[$name]) === true) {
            return static::$fadeInstances[$name];
        }

        static::$fadeInstances[$name] = static::$app->getContainer()->get($name);

        return static::$fadeInstances[$name];
    }

    public static function __callStatic($method, $args) {
        $instance = static::getFacadeRoot();

        return $instance->$method(...$args);
    }

    public static function getFacadeAccessor() {
        throw new \RuntimeException('The facade object must implement getFacadeAccessor method.');
    }

}
