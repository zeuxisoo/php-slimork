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
        $slim_config  = require CONFIG_ROOT.'/slim.php';
        $final_config = [
            'settings' => $slim_config
        ];

        // Merge all config in settings namespace
        foreach(glob(CONFIG_ROOT."/*.php") as $file_path) {
            $file_name = basename($file_path, ".php");

            if ($file_name !== 'slim') {
                $final_config['settings'][$file_name] = require_once $file_path;
            }
        }

        // Make the slim config in global with `settings` prefix
        foreach($slim_config as $name => $value) {
            $final_config['settings.'.$name] = $value;
        }

        $this->settings = $final_config;
    }

    protected function setupEnvironments() {
        // Timezoom
        date_default_timezone_set($this->settings['settings']['app']['timezone']);
    }

    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

}
