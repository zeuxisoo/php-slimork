<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\Controller;

class HomeController extends Controller {

    public function index(Request $request, Response $response, array $arguments) {
        return $this->render('index.html');
    }

}
