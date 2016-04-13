<?php
namespace App\Contracts;

use Slim\App;

abstract class Middleware {

    protected $app;
    protected $container;

    public function __construct(App $app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

}
