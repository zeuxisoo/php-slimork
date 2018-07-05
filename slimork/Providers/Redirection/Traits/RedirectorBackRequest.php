<?php
namespace Slimork\Providers\Redirection\Traits;

trait RedirectorBackRequest {

    public function back($status = 302, $headers = null) {
        $referer_url = $this->getHttpReferer();
        $back_url    = empty($referer_url) === false ? $referer_url : $this->getPreviousUrlFromSession();

        return $this->createRedirect(
            empty($back_url) === false ? $back_url : '/',
            $status
        );
    }

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

    public function setPreviousUrl($url) {
        $this->session->set('_redirector.form.previous_url', $url);
    }

    public function previousUrl() {
        return $this->session->get('_redirector.form.previous_url');
    }

}
