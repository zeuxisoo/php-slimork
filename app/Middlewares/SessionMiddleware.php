<?php
namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SessionMiddleware {

    protected $app;
    protected $container;

    protected $options = [
        'name'     => '_s',
        'life_time' => 3600, // 1 hour
        'path'     => '/',
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ];

    public function __construct($app) {
        $this->app       = $app;
        $this->container = $app->getContainer();

        $this->options = array_merge($this->options, $this->container->settings['app']['session']);

        // Start it without deferred to solve Csrf service throw exception _SESSION not init
        $this->start();
    }

    public function __invoke(Request $request, Response $response, $next) {
        $this->start();

        return $next($request, $response);
    }

    public function start() {
        if (in_array(session_status(), [PHP_SESSION_DISABLED, PHP_SESSION_ACTIVE]) === true) {
            return;
        }

        // Setup cookie paramters
        $current = session_get_cookie_params();

        $life_time = $this->options['life_time'] ?: $current['life_time'];
        $path      = $this->options['path'] ?: $current['path'];
        $domain    = $this->options['domain'] ?: $current['domain'];
        $secure    = $this->options['secure'];
        $httponly  = $this->options['httponly'];

        // Setup session
        session_name($this->options['name']);
        session_set_cookie_params($life_time, $path, $domain, $secure, $httponly);
        session_cache_limiter(false);

        // Start
        if (PHP_SAPI === 'cli') {
            @session_start();
        }else{
            session_start();
        }
    }

}
