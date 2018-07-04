# Validation

This service provider to provide `Respect` validation service in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Validation\ValidationServiceProvider::class,
            ...
        ]

## Usage

First, you need to import the validation rule namespace to create your rule statement

    use Slimork\Providers\Validation\Rule;


And then, you can get the validator object from the service provider in any controller

    $validator = $this->validator;

Now, add rule for request paramters

    $validator->validators($request->getParams(), [
        'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
        'password' => Rule::notEmpty()->length(8, 30),
    ]);

If you need to custom the translations, you can using the third arguments like

    $validator->validators($request->getParams(), [
        'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
        'password' => Rule::notEmpty()->length(8, 30),
    ], [
        'username.notEmpty' => "The {{name}} is empty",
        'username.length' => "The {{name}} must have a length between {{minValue}} and {{maxValue}}"
    ]);

Finally, you can call the `fails()` method to check is or not passed, `errors()` method to get all errors and `firstError()` method to get fisrt error message

    if ($validator->fails() === true) {
        // Format like: [ 'username' => ['notEmpty' => 'message', ...] , 'password' => ['notEmpty' => 'message', ...] ]
        $errors = $validator->errors();

        // Format like: ['notEmpty' => 'message', 'length' => 'message']
        $errors = $validator->errors('username');

        // The top of error message in errors stack
        $error = $validator->firstError();
    }else{
        ...
        ...
    }
