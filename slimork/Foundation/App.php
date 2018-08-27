<?php
namespace Slimork\Foundation;

use DI\Bridge\Slim\App as SlimApp;
use DI\ContainerBuilder;

class App extends SlimApp {

    protected $settings;

    protected $beforeBootstrappers = [
        Bootstrappers\Base\LoadSettings::class,
    ];

    protected $afterBootstrappers = [
        Bootstrappers\BuiltIn\RegisterFacades::class,
        Bootstrappers\BuiltIn\RegisterHandlers::class,
        Bootstrappers\BuiltIn\RegisterMiddlewares::class,
        Bootstrappers\BuiltIn\RegisterServiceProviders::class,
    ];

    // Overwrite the constructor to clear the original initialization and initialize it later
    public function __construct() {
    }

    // Implementation for build the app container
    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

    // Loaders
    public function loadBeforeBootstrappers() {
        foreach($this->beforeBootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }
    }

    public function loadAppCore() {
        parent::__construct();
    }

    public function loadAfterBootstrappers() {
        foreach($this->afterBootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }
    }

    public function loadRoutes() {
        // expose the $app object
        $app = $this;

        require_once APP_ROOT.'/routes.php';
    }

    // Helpers
    public function setSettings(array $settings) {
        $this->settings = $settings;
    }

    public function getSettings() {
        return $this->settings;
    }

    public function getSetting($name) {
        $settings = $this->getContainer()->get('settings');

        if (array_key_exists($name, $settings) === true) {
            return $settings[$name];
        }else{
            return [];
        }
    }

    public function getBeforeBootstrappers() {
        return $this->beforeBootstrappers;
    }

    public function setBeforeBootstrappers(array $bootstrappers) {
        $this->beforeBootstrappers = $bootstrappers;
    }

    public function getAfterBootstrappers() {
        return $this->afterBootstrappers;
    }

    public function setAfterBootstrappers(array $bootstrappers) {
        $this->afterBootstrappers = $bootstrappers;
    }

}
