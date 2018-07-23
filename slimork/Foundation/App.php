<?php
namespace Slimork\Foundation;

use DI\Bridge\Slim\App as SlimApp;
use DI\ContainerBuilder;
use Slimork\Facades\Facade;

class App extends SlimApp {

    protected $settings;

    public function __construct() {
        $this->setupSettings();
        $this->setupEnvironments();

        parent::__construct();

        $this->setupFacades();
        $this->setupHandlers();
        $this->setupMiddlewares();
        $this->setupServiceProviders();
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

        $this->settings = $final_config;
    }

    // Setup enviroments
    protected function setupEnvironments() {
        date_default_timezone_set($this->settings['settings']['app']['timezone']);
    }

    // Implementation
    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

    // Setup facades
    protected function setupFacades() {
        Facade::setFacadeApplication($this);

        AliasLoader::getInstance($this->getSetting('app')['aliases'])->register();
    }

    // Setup handlers
    protected function setupHandlers() {
        foreach($this->getSetting('app')['handlers'] as $handler) {
            $handler = new $handler($this);
            $handler->register();
        }
    }

    // Setup middlewares
    protected function setupMiddlewares() {
        foreach($this->getSetting('app')['middlewares'] as $middleware) {
            $this->add(new $middleware($this));
        }
    }

    // Setup service providers
    protected function setupServiceProviders() {
        $providers = [];

        foreach($this->getSetting('app')['providers'] as $provider) {
            $provider = new $provider($this);
            $provider->register();

            array_push($providers, $provider);
        }

        foreach($providers as $provider) {
            $provider->boot();
        }
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
