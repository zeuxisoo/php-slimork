<?php
namespace Slimork\Providers\View;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class ViewManager {

    protected $container;
    protected $view;

    public function __construct($container) {
        $this->container = $container;

        $this->setupView();
    }

    public function setupView() {
        $settings = $this->container->get('settings');
        $request  = $this->container->get('request');
        $router   = $this->container->get('router');

        $view_path  = RESOURCES_ROOT.'/views';
        $cache_path = STORAGE_ROOT.'/cache/views';
        $base_path  = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');

        $view = new Twig($view_path, array_merge([
            'charset'          => 'utf-8',
            'auto_reload'      => true,
            'strict_variables' => false,
            'autoescape'       => 'html',

            'cache'            => $cache_path,
        ], $settings['view']['default']));

        $view->addExtension(new TwigExtension($router, $base_path));

        foreach($settings['view']['extensions'] as $extension) {
            $view->addExtension(new $extension($this->container));
        }

        $this->view = $view;
    }

    // Custom the render methods to replace the original render($response, $view_file, $data) methods
    public function render($view, array $arguments = []) {
        $response = $this->container->get('response');
        $response = $this->view->render($response, $view, $arguments);

        return $response;
    }

    public function __call($method, $arguments) {
        return $this->view->$method(...$arguments);
    }

}
