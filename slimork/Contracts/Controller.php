<?php
namespace Slimork\Contracts;

use Psr\Container\ContainerInterface;

abstract class Controller {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function __get($name) {
        return $this->container->get($name);
    }

    /**
     * Usage
     * =====
     *
     * View:
     *
     *     $this->view('template.html');
     *     $this->view('template.html', compact('variable1', 'variable2'));
     */
    protected function view($view, array $arguments = []) {
        $response = $this->response;
        $response = $this->view->render($response, $view, $arguments);

        return $response;
    }

}
