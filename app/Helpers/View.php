<?php
namespace App\Helpers;

use Slim\Slim;

class View extends \Twig_Extension {

    public function getName() {
        return 'app';
    }

    public function __construct() {
        $this->slim = Slim::getInstance();
    }

    public function getFunctions() {
        return array(
            // new \Twig_SimpleFunction('<NAME>', array($this, '<Method>')),
        );
    }

    public function getFilters() {
        return array(
            // new \Twig_SimpleFilter('<NAME>', array($this, '<Method>')),
        );
    }

}
