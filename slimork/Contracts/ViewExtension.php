<?php
namespace Slimork\Contracts;

use Twig_Extension;

class ViewExtension extends Twig_Extension {

    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getFilters() {
        return [
            // new Twig_SimpleFilter('name', [$this, 'method']),
        ];
    }

}
