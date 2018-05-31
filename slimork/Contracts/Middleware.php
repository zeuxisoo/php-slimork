<?php
namespace Slimork\Contracts;

use Slimork\Foundation\App;

abstract class Middleware {

    protected $app;
    protected $container;

    public function __construct(App $app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

}
