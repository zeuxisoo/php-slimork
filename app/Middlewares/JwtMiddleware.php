<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/**
 * Usage
 * =====
 *
 * Auth
 *
 *      use App\Middlewares\JwtMiddleware;
 *
 *      $jwt_middleware = new JwtMiddleware($app);
 *
 *      $app->get('/auth', function($request, $resposne, $args) {
 *          return $resposne->write('Logged in');
 *      })->add($jwt_middleware);
 */
class JwtMiddleware {

    protected $app;
    protected $container;

    protected $header_field = 'authorization';
    protected $token_prefix = 'bearer';

    public function __construct($app) {
        $this->app       = $app;
        $this->container = $app->getContainer();
    }

    public function __invoke(Request $request, Response $response, $next) {
        $token_value  = "";
        $header_field = $request->getHeader($this->header_field);
        $header_field = array_pop($header_field);

        if ($header_field && stripos($header_field, $this->token_prefix) === 0) {
            $token_value = trim(str_ireplace($this->token_prefix, '', $header_field));
        }

        if (empty($token_value) === true) {
            return $this->renderError($request, $response, 'Token not provided');
        }

        try {
            $user = $this->container->jwt->parseToken($token_value)->authenticate();

            return $next($request, $response);
        }catch(\Exception $e) {
            return $this->renderError($request, $response, $e->getMessage());
        }
    }

    private function renderError($request, $response, $message) {
        $response = $response->withStatus(400);

        if ($request->isXhr() === true) {
            return $response->withJSON(['message' => $message]);
        }else{
            return $response->write($message);
        }
    }

}
