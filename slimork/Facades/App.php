<?php
namespace Slimork\Facades;

class App extends Facade {

    public static function getFacadeAccessor() {
        return self::getFacadeApplication();
    }

}
