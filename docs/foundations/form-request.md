# FormRequest

A easy way for you to validate the input data before process or store data

## Usage

Create `Request` object like `LoginRequest` first, and the content like

File: app\Requests\LoginRequest.php

    <?php
    namespace App\Requests;

    use Slimork\Foundation\Http\FormRequest;
    use Slimork\Providers\Validation\Rule;

    class LoginRequest extends FormRequest {

        public function rules() {
            return [
                'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
                'password' => Rule::notEmpty()->length(8, 30),
            ];
        }

        public function messages() {
            return [];
        }

    }

Now, import the `LoginRequest` object in the controller object, and the related variable will be auto validated and redirect back to submit page automatically when got error

File: app\Controllers\HomeController.php

    <php
    namespace App\Controllers;

    use App\Requests\LoginRequest;

    class HomeController extends Controller {

        public function test(LoginRequest $loginRequest) {
            dd(
                $loginRequest->getParams()
            );
        }

    }

## Notes

You cannot be using the variable named `$request` for any `FormRequest` object, because of this variable was declared and pointed to the `Slim\Http\Request` object in the PHP-DI container
