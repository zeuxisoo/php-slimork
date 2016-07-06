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

    /**
     * Usage
     *
     * JSON:
     *
     *      $this->json(User::find(1)->toArray());
     */
    protected function json(array $data) {
        return $this->response->withJSON($data);
    }

    /**
     * Usage
     *
     * Redirect:
     *
     *      $this->redirect($this->router->pathFor('name'));
     */
    protected function redirect($url) {
        return $this->response->withStatus(302)->withHeader('Location', $url);
    }

}
