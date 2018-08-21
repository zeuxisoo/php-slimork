<?php
namespace Slimork\Foundation;

use DI\Bridge\Slim\App as SlimApp;
use DI\ContainerBuilder;

class App extends SlimApp {

    protected $settings;

    protected $baseBootstrappers = [
        Bootstrappers\Base\LoadSettings::class,
    ];

    protected $builtInBootstrappers = [
        Bootstrappers\BuiltIn\RegisterFacades::class,
        Bootstrappers\BuiltIn\RegisterHandlers::class,
        Bootstrappers\BuiltIn\RegisterMiddlewares::class,
        Bootstrappers\BuiltIn\RegisterServiceProviders::class,
    ];

    public function __construct(array $base_bootstrappers = []) {
        foreach(array_merge($this->baseBootstrappers, $base_bootstrappers) as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }

        parent::__construct();
    }

    // Implementation
    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions($this->settings);
    }

    //
    public function loadBuiltInBootstrappers() {
        foreach($this->builtInBootstrappers as $bootstrapper) {
            (new $bootstrapper())->bootstrap($this);
        }
    }

    public function loadRoutes() {
        // expose the $app object
        $app = $this;

        require_once APP_ROOT.'/routes.php';
    }

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

    public function getBuiltInBootstrappers() {
        return $this->builtInBootstrappers;
    }

    public function setBuiltInBootstrappers(array $bootstrappers) {
        $this->builtInBootstrappers = $bootstrappers;
    }

}
