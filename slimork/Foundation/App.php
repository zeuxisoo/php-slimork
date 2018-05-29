<?php
namespace Slimork\Foundation;

use DI\Bridge\Slim\App as SlimApp;
use DI\ContainerBuilder;

class App extends SlimApp {

    protected $settings;

    public function __construct() {
        $this->setupSettings();
        $this->setupEnvironments();

        parent::__construct();
    }

    protected function setupSettings() {
        $settings = [];

        // Merge all settings
        foreach(glob(CONFIG_ROOT."/*.php") as $file_path) {
            $file_name    = basename($file_path, ".php");
            $setting_name = $file_name === 'slim' ? 'settings' : $file_name;

            $settings[$setting_name] = require_once $file_path;
        }

        // Make the slim settings in global with `settings` prefix
        foreach($settings['settings'] as $name => $value) {
            $settings['settings.'.$name] = $value;
        }

        $this->settings = $settings;
    }

    protected function setupEnvironments() {
        // Timezoom
        date_default_timezone_set($this->settings['app']['timezone']);
    }

    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

}
