<?php
namespace Slimork\Contracts;

use Slimork\Foundation\App;

abstract class ExceptionHandler {

    protected $app;
    protected $container;

    public function __construct(App $app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    abstract public function register();

}
