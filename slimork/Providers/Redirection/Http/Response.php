<?php
namespace Slimork\Providers\Redirection\Http;

use Slim\Http\Response as SlimResponse;

class Response extends SlimResponse {

    protected $redirector;
    protected $request;
    protected $flash;

    public function setRedirector($redirector) {
        $this->redirector = $redirector;

        return $this;
    }

    public function setRequest($request) {
        $this->request = $request;

        return $this;
    }

    public function setFlash($flash) {
        $this->flash = $flash;

        return $this;
    }

    public function withRequestParams($params = []) {
        $this->redirector->setRequestParams(
            empty($params) === false ? $params : $this->request->getParams()
        );

        return $this;
    }

    public function withError($error) {
        $this->flash->setError($error);

        return $this;
    }

    public function withSuccess($message) {
        $this->flash->setSuccess($message);

        return $this;
    }

    public function withTypeMessage($type, $message) {
        $this->flash->setTypeMessage($type, $message);

        return $this;
    }

}
