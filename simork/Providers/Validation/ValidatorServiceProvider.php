<?php
namespace Simork\Providers\Validation;

use Simork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Validator:
 *
 *      # Import validator namespace for create rule
 *      use Respect\Validation\Validator as v;
 *
 *      # Make validator with request paramters and related rules
 *      $validator = $this->validator;
 *      $validator->validators($request->getParams(), [
 *          'username' => v::notEmpty()->noWhitespace()->length(4, 30),
 *          'password' => v::notEmpty()->length(8, 30),
 *      ]);
 *
 *      # Make validator with request paramters, related rules and translations
 *      $validator = $this->validator;
 *      $validator->validators($request->getParams(), [
 *          'username' => v::notEmpty()->noWhitespace()->length(4, 30),
 *          'password' => v::notEmpty()->length(8, 30),
 *      ], [
 *          'username.notEmpty' => "The {{name}} is empty",
 *          "username.length" => "The {{name}} must have a length between {{minValue}} and {{maxValue}}"
 *      ]);
 *
 *      # Trigger validator and retrieve errors
 *      if ($validator->fails() === true) {
 *
 *          # All errors [ 'username' => ['notEmpty' => 'message', ...] , 'password' => ['notEmpty' => 'message', ...] ]
 *          $errors = $validator->errors();
 *
 *          # All username errors ['notEmpty' => 'message', 'length' => 'message']
 *          $errors = $validator->errors('username');
 *
 *          # The top of error in errors stack
 *          $errors = $validator->firstError();
 *
 *      }else{
 *          ...
 *          ...
 *      }
 */
class ValidatorServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['validator'] = function() {
            return new Validator();
        };
    }

}
