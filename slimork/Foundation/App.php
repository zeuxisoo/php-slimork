<?php
namespace Slimork\Foundation;

use DI\Bridge\Slim\App as SlimApp;
use DI\ContainerBuilder;

class App extends SlimApp {

    protected $settings;

    protected $afterAppBootstrappers = [
        Bootstrappers\RegisterFacades::class,
        Bootstrappers\RegisterHandlers::class,
        Bootstrappers\RegisterMiddlewares::class,
        Bootstrappers\RegisterServiceProviders::class,
    ];

    public function __construct() {
        $this->setupSettings();

        parent::__construct();

        $this->setupAfterAppBootstrappers();
    }

    // Setup settings
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

        date_default_timezone_set($final_config['settings']['app']['timezone']);

        $this->settings = $final_config;
    }

    // Setup after app bootstraps
    protected function setupAfterAppBootstrappers() {
        foreach($this->afterAppBootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }
    }

    // Implementation
    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

    // Functions
    public function getSetting($name) {
        $settings = $this->getContainer()->get('settings');

        if (array_key_exists($name, $settings) === true) {
            return $settings[$name];
        }else{
            return [];
        }
    }

}
