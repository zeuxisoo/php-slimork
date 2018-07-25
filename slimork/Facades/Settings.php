<?php
namespace Slimork\Facades;

class Settings extends Facade {

    public static function getFacadeAccessor() {
        return static::getFacadeApplication();
    }

    public static function set($key, $value) {
        $old_settings = static::$app->getContainer()->get('settings');
        $new_settings = array_merge($old_settings, [
            $key => $value
        ]);

        static::$app->getContainer()->set('settings', $new_settings);

        return $new_settings;
    }

    public static function get($key, $default = null) {
        $settings = static::$app->getContainer()->get('settings');

        return array_key_exists($key, $settings) === true ? $settings[$key] : $default;
    }

}
