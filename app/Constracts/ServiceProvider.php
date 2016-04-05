<?php
namespace App\Constracts;

abstract class ServiceProvider {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

}
