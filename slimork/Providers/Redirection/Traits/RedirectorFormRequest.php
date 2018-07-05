<?php
namespace Slimork\Providers\Redirection\Traits;

trait RedirectorFormRequest {

    public function setRequestParams($params) {
        $this->session->set('_redirector.form.request_params', $params);
    }

    public function getRequestParam($key, $default = null) {
        if ($this->session->has('_redirector.form.request_params') === true) {
            $params = $this->session->get('_redirector.form.request_params');

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
