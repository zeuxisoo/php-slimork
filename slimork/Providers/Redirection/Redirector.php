<?php
namespace Slimork\Providers\Redirection;

use RuntimeException;

class Redirector {

    const PREVIOUS_URL_NAME   = "_redirector.previous_url";
    const REQUEST_PARAMS_NAME = "_redirector.request_params";

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

    public function back($status = 302, $headers = null) {
        $referer_url = $this->getHttpReferer();
        $back_url    = empty($referer_url) === false ? $referer_url : $this->getPreviousUrlFromSession();

        return $this->createRedirect(
            empty($back_url) === false ? $back_url : '/',
            $status
        );
    }

    //
    public function getHttpReferer() {
        $headers  = $this->request->getHeaders();
        $referers = array_key_exists('HTTP_REFERER', $headers) === true ? $headers['HTTP_REFERER'] : [];
        $referer  = empty($referers) === true ? '' : current($referers);

        return $referer;
    }

    public function getPreviousUrlFromSession() {
        if ($this->container->has('session') === true) {
            return $this->session->previousUrl();
        }else{
            return '';
        }
    }

    public function createRedirect($path, $status = 302, $headers = null) {
        $response = new Http\Response($status, $headers);
        $response = $response->setRedirector($this);

        if ($this->container->has('flash') === true) {
            $response = $response->setFlash($this->container->get('flash'));
        }

        return $response->setRequest($this->request)->withRedirect($path);
    }

    //
    public function setPreviousUrl($url) {
        $this->session->set(self::PREVIOUS_URL_NAME, $url);
    }

    public function previousUrl() {
        return $this->session->get(self::PREVIOUS_URL_NAME);
    }

    public function setRequestParams($params) {
        $this->session->set(self::REQUEST_PARAMS_NAME, $params);
    }

    public function getRequestParam($key, $default = null) {
        if ($this->session->has(self::REQUEST_PARAMS_NAME) === true) {
            $params = $this->session->get(self::REQUEST_PARAMS_NAME);

            if (array_key_exists($key, $params) === true) {
                $value = $params[$key];

                unset($params[$key]);

                $this->setRequestParams($params);

                return $value;
            }else{
                return $default;
            }
        }else{
            return "";
        }
    }

}
