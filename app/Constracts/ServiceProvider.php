<?php
namespace App\Constracts;

use Interop\Container\ContainerInterface;

abstract class ServiceProvider {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

}
