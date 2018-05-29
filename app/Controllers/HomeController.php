<?php
namespace App\Controllers;

use Slimork\Contracts\Controller;

class HomeController extends Controller {

    public function index($response) {
        return $this->view('index.html');
    }

}
