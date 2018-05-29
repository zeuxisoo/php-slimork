<?php
namespace App\Controllers;

use Slimork\Contracts\Controller;

class HomeController extends Controller {

    public function index($request, $response) {
        return $response->write('Hello world');
    }

}
