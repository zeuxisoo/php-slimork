<?php
namespace Simork\Contracts;

use Slim\App;

abstract class ServiceProvider {

    protected $app;
    protected $container;

    public function __construct(App $app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    public function boot() {

    }

    abstract function register();

}
