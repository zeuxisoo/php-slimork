<?php
namespace App\Providers\Debugbar\Controllers;

use Interop\Container\ContainerInterface;

class AssetsController {

    protected $container;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function css() {
        $renderer = $this->container['debugbar']->getJavascriptRenderer();

        $content  = $renderer->dumpAssetsToString('css');

        $response = $this->container['response']->withHeader('Content-Type', 'text/css')->write($content);

        return $response;
    }

    public function js() {
        $renderer = $this->container['debugbar']->getJavascriptRenderer();

        $content  = $renderer->dumpAssetsToString('js');

        $response = $this->container['response']->withHeader('Content-Type', 'text/javascript')->write($content);

        return $response;
    }

}
