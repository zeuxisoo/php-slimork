<?php
namespace Slimork\Providers\Redirection;

use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Slimork\Contracts\ViewExtension as SimorkViewExtension;

class ViewExtension extends SimorkViewExtension {

    public function getName() {
        return 'RedirectionViewExtension';
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction('old_param', [$this, 'oldParam']),
        ];
    }

    /*
     * example:
     *
     *    {{ old_param(key, $default = null) }}
     */
    public function oldParam($key, $default = null) {
        $redirect = $this->container->get('redirect');

        return $redirect->getRequestParam($key, $default);
    }

}
