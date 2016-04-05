<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Constracts\Controller;

class HomeController extends Controller {

    public function index(Request $request, Response $response, array $arguments) {
        $this->logger->addInfo('called index handler');

        return $this->view->render($response, 'index.html');
    }

}
