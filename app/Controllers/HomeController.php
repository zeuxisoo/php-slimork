<?php
namespace App\Controllers;

use Slimork\Contracts\Controller;

class HomeController extends Controller {

    public function index() {
        return $this->view('index.html');
    }

}
