<?php
namespace Slimork\Providers\Validation;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Validation:
 *
 *      # Import validator namespace for create rule
 *      use Slimork\Providers\Validation\Rule;
 *
 *      # Make validator with request paramters and related rules
 *      $validator = $this->validator;
 *
 *      $validator->validators($request->getParams(), [
 *          'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
 *          'password' => Rule::notEmpty()->length(8, 30),
 *      ]);
 *
 *      # Make validator with request paramters, related rules and translations
 *      $validator = $this->validator;
 *
 *      $validator->validators($request->getParams(), [
 *          'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
 *          'password' => Rule::notEmpty()->length(8, 30),
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
class ValidationServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('validator', function() {
            return new Validator();
        });
    }

}
