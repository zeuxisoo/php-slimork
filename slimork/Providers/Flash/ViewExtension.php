<?php
namespace Slimork\Providers\Flash;

use Twig_SimpleFunction;
use Twig_SimpleFilter;
use Slimork\Contracts\ViewExtension as SimorkViewExtension;

class ViewExtension extends SimorkViewExtension {

    public function getName() {
        return 'FlashViewExtension';
    }

    public function getFunctions() {
        return [
            new Twig_SimpleFunction('has_flash', [$this, 'hasFlash']),
            new Twig_SimpleFunction('flash', [$this, 'flash']),
        ];
    }

    /**
     * example:
     *
     *     {% if has_flash('error') %}
     *         <div class="alert alert-error alert-danger">
     *             <strong>Error!</strong>&nbsp;{{ flash('error') }}
     *         </div>
     *     {% endif %}
     */
    public function hasFlash($type) {
        return $this->container->get('flash')->getMessage($type);
    }

    public function flash($type) {
        return $this->container->get('flash')->getTypeMessage($type);
    }

}
