<?php
namespace Slimork\Providers\Log\Handlers;

use Monolog\Logger as MonoLogger;

class LogHandler {

    protected $name;
    protected $settings;

    public function __construct($name, $settings) {
        $this->name     = $name;
        $this->settings = $settings;

        // Make sure the level is correct
        $monolog_levels = array_keys(MonoLogger::getLevels());
        $settings_level = strtoupper($this->settings['level']);

        if (in_array($settings_level, $monolog_levels) === false) {
            $this->settings['level'] = MonoLogger::DEBUG;
        }
    }

    public function getLevel() {
        return $this->settings['level'];
    }

    public function getFilename() {
        throw new \RuntimeException('The log handler object must implement getFilename method.');
    }

    public function getHandler() {
        throw new \RuntimeException('The log handler object must implement getHandler method.');
    }

}
