<?php
namespace Slimork\Providers\Validation;

use Respect\Validation\Exceptions\NestedValidationException;
use Slimork\Contracts\ServiceProvider;

class Validator {

    protected $parameters   = [];
    protected $validators   = [];
    protected $translations = [];

    protected $errors       = [];

    public function validators(array $parameters, array $validators, array $translations = []) {
        $this->parameters   = $parameters;
        $this->validators   = $validators;
        $this->translations = $translations;

        $this->check();

        return $this;
    }

    public function check() {
        foreach ($this->validators as $key => $validator) {
            $parameter = array_key_exists($key, $this->parameters) ? $this->parameters[$key] : "";

            try {
                $validator->setName($key)->assert($parameter);
            }catch(NestedValidationException $exception) {
                foreach ($exception as $e) {
                    $exception_id     = $e->getId();
                    $translation_name = $key.'.'.$exception_id;

                    if (array_key_exists($translation_name, $this->translations) === true) {
                        $e->setTemplate($this->translations[$translation_name]);
                    }

                    $this->errors[$key][$exception_id] = $e->getMessage();
                }
            }
        }
    }

    public function fails() {
        return empty($this->errors) === false;
    }

    public function errors($parameter = "") {
        if (empty($parameter) === true) {
            return $this->errors;
        }else{
            return array_key_exists($parameter, $this->errors) ? $this->errors[$parameter] : null;
        }
    }

    public function firstError() {
        $errors = $this->errors();

        return current(array_shift($errors));
    }

}
