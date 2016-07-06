<?php
namespace App\Helpers;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

class ViewHelper extends Twig_Extension {

    private $container;

    public function __construct($container) {
        $this->container = $container;
    }

    public function getName() {
        return 'ViewHelper';
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction('lang', [$this, 'lang']),
            new Twig_SimpleFunction('has_flash', [$this, 'hasFlash']),
            new Twig_SimpleFunction('flash', [$this, 'flash']),
            new Twig_SimpleFunction('auth_user', [$this, 'authUser']),
            new Twig_SimpleFunction('csrf_tags', [$this, 'csrfTags']),
        ];
    }

    public function getFilters() {
        return [
            // new Twig_SimpleFilter('name', [$this, 'method']),
        ];
    }

    /**
     * example:
     *
     *     {{ lang("Hello World!") }}
     *     {{ lang("Hello World! My name is %name%", {'%name%': 'Cat'}) }}
     */
    public function lang($message, $arguments = array(), $domain = null, $locale = null) {
        return lang($message, $arguments, $domain, $locale);
    }

    /**
     * example:
     *
     *     {% if hasFlash('error') %}
     *         <div class="alert alert-error alert-danger">
     *             <strong>Error!</strong>&nbsp;{{ flash('error') }}
     *         </div>
     *     {% endif %}
     */
    public function hasFlash($type) {
        return $this->container->flash->getMessage($type);
    }

    public function flash($type) {
        return $this->container->flash->getTypeMessage($type);
    }

    /**
     * example:
     *
     *     {% if (authUser()) %}
     *          Sign out
     *     {% endfor %}
     */
    public function authUser() {
        return $this->container->auth->user();
    }

    /**
     * example:
     *
     *     {{ csrf_tags() }}
     */
    public function csrfTags() {
        return $this->csrf->getTokenForHiddenInputTags();
    }

}
