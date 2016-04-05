<?php
namespace App\Constracts;

use Interop\Container\ContainerInterface;

abstract class Controller {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __get($name) {
        return $this->container->get($name);
    }

}
