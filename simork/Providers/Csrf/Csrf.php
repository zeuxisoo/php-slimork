<?php
namespace Simork\Providers\Csrf;

use Psr\Http\Message\ServerRequestInterface;
use Slim\Csrf\Guard;

class Csrf extends Guard {

    protected $request;

    // @override
    //
    // Expose the $request object for getFormHiddenInputs methods
    public function generateNewToken(ServerRequestInterface $request) {
        $this->request = parent::generateNewToken($request);

        return $this->request;
    }

    public function setStrength($length = 16) {
        $this->strength = $length;
    }

    public function getTokens() {
        $token_name_key  = $this->getTokenNameKey();
        $token_value_key = $this->getTokenValueKey();

        $csrf = [
            $token_name_key => $this->request->getAttribute($token_name_key),
            $token_value_key => $this->request->getAttribute($token_value_key)
        ];

        return $csrf;
    }

    public function getTokenForHiddenInputTags() {
        $html = [];

        foreach($this->getTokens() as $name => $value) {
            array_push($html, sprintf("<input type='hidden' name='%s' value='%s' />", $name, $value));
        }

        return join("\n", $html);
    }

    public function getTokenForMetaTags() {
        $html = [];

        foreach($this->getTokens() as $name => $value) {
            array_push($html, sprintf("<meta name='%s' content='%s' />", $name, $value));
        }

        return join("\n", $html);
    }

}
