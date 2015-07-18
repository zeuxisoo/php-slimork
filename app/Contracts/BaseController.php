<?php
namespace App\Contracts;

use Slim\Slim;

class BaseController {

    public function __construct() {
        $this->app = Slim::getInstance();
    }

}
