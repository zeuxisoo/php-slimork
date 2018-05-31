<?php
namespace Slimork\Contracts;

use Slimork\Foundation\App;

abstract class ServiceProvider {

    protected $app;
    protected $container;

    public function __construct(App $app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    // Optional, After service provider was registered, this method will triggered
    public function boot() {
    }

    abstract function register();

}
