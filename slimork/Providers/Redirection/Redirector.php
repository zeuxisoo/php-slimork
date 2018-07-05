<?php
namespace Slimork\Providers\Redirection;

use RuntimeException;

class Redirector {

    use Traits\RedirectorBackRequest;
    use Traits\RedirectorFormRequest;

    protected $container;
    protected $request;
    protected $response;
    protected $router;
    protected $session;

    public function __construct($container) {
        $this->container = $container;

        if ($this->container->has('session') === false) {
            throw new RuntimeException('The session service provider does exists');
        }

        $this->request   = $this->container->get('request');
        $this->response  = $this->container->get('response');
        $this->router    = $this->container->get('router');
        $this->session   = $this->container->get('session');
    }

    //
    public function to($path, $status = 302, $headers = null) {
        return $this->createRedirect($path, $status, $hreaders);
    }

    public function away($path, $status = 302, $hreaders = null) {
        return $this->createRedirect($path, $status, $hreaders);
    }

    public function route($name, $data = [], $query_parameters = [], $status = 302, $headers = null) {
        return $this->away(
            $this->router->pathFor($name, $data, $query_parameters),
            $status,
            $headers
        );
    }

    public function createRedirect($path, $status = 302, $headers = null) {
        $response = new Http\Response($status, $headers);
        $response = $response->setRedirector($this);

        if ($this->container->has('flash') === true) {
            $response = $response->setFlash($this->container->get('flash'));
        }

        return $response->setRequest($this->request)->withRedirect($path);
    }

}
