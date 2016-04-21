<?php
namespace App\Helpers;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

class ViewHelper extends Twig_Extension {

    public function getName() {
        return 'ViewHelper';
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction('lang', [$this, 'lang']),
        ];
    }

    public function getFilters() {
        return [
            // new Twig_SimpleFilter('name', [$this, 'method']),
        ];
    }

    /**
     * View
     *
     * example:
     *
     *     {{ lang("Hello World!") }}
     *     {{ lang("Hello World! My name is %name%", {'%name%': 'Cat'}) }}
     */
    public function lang($message, $arguments = array(), $domain = null, $locale = null) {
        return lang($message, $arguments, $domain, $locale);
    }

}
