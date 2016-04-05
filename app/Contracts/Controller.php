<?php
namespace App\Contracts;

use Interop\Container\ContainerInterface;

abstract class Controller {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __get($name) {
        return $this->container->get($name);
    }

    protected function render($view, array $arguments = []) {
        $response = $this->response;
        $response = $this->view->render($response, $view, $arguments);

        return $response;
    }

}
