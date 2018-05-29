<?php
namespace Slimork\Providers\View;

use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Twig_SimpleTest;
use Slimork\Contracts\ViewExtension;

class DefaultViewExtension extends ViewExtension {

    public function getName() {
        return 'DefaultViewExtension';
    }

    public function getFunctions() {
        return [
            // new Twig_SimpleFunction('name', [$this, 'method']),
        ];
    }

    public function getFilters() {
        return [
            // new Twig_SimpleFilter('name', [$this, 'method']),
        ];
    }

    public function getTests() {
        return [
            new \Twig_SimpleTest('string', [$this, 'is_string']),
            new \Twig_SimpleTest('array', [$this, 'is_array']),
        ];
    }

    public function is_string($value) {
        return is_string($value);
    }

    public function is_array($value) {
        return is_array($value);
    }

}
