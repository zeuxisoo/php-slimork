<?php
namespace Slimork\Facades;

class App extends Facade {

    // return the Slim\App instance
    public static function getFacadeAccessor() {
        return self::getFacadeApplication();
    }

}
