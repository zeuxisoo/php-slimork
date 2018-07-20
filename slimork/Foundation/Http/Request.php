<?php
namespace Slimork\Foundation\Http;

use RuntimeException;
use DI\Container;
use Slim\Http\{
    Request as SlimRequest,
    Uri,
    Headers,
    Cookies,
    RequestBody,
    UploadedFile
};

/*
 * Example
 *
 *  File: app\Requests\LoginRequest.php
 *
 *      class LoginRequest extends Request {
 *
 *          public function rules() {
 *              return [
 *                  'username' => Rule::notEmpty()->noWhitespace()->length(4, 30),
 *                  'password' => Rule::notEmpty()->length(8, 30),
 *              ];
 *          }
 *
 *          public function messages() {
 *              return [];
 *          }
 *
 *      }
 *
 *  File: app\Controllers\HomeController.php
 *
 *      class HomeController extends Controller {
 *
 *          public function test(LoginRequest $loginRequest) {
 *              dd(
 *                  $loginRequest->getParams()
 *              );
 *          }
 *
 *      }
 *
 */
abstract class Request extends SlimRequest {

    protected $container;

    public function __construct(Container $container) {
        $environment = $container->get('environment');

        // Re-create the environment
        $method        = $environment['REQUEST_METHOD'];
        $uri           = Uri::createFromEnvironment($environment);
        $headers       = Headers::createFromEnvironment($environment);
        $cookies       = Cookies::parseHeader($headers->get('Cookie', []));
        $serverParams  = $environment->all();
        $body          = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($environment);

        parent::__construct($method, $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);

        // Handle the post action
        $has_form_data = in_array($this->getMediaType(), ['application/x-www-form-urlencoded', 'multipart/form-data']);

        if ($method === 'POST' && $has_form_data === true) {
            $this->withParsedBody($_POST);
        }

        // Set the container
        $this->container = $container;

        // Validate the form data
        $this->validate();
    }

    public function validate() {
        if ($this->container->has('validator') === false) {
            throw new RuntimeException("The validation service provider does not exists");
        }

        if ($this->container->has('redirect') === false) {
            throw new RuntimeException("The redirection service provider does not exists");
        }

        //
        $validator = $this->container->get('validator');
        $redirect  = $this->container->get('redirect');

        //
        $validator->validators($this->getParams(), $this->rules(), $this->messages());

        if ($validator->fails() === true) {
            $response = $redirect->back()->withRequestParams()->withError($validator->firstError());

            if (headers_sent() === false) {
                foreach ($response->getHeaders() as $name => $values) {
                    foreach ($values as $value) {
                        header(sprintf('%s: %s', $name, $value), false);
                    }
                }

                header(sprintf(
                    'HTTP/%s %s %s',
                    $response->getProtocolVersion(),
                    $response->getStatusCode(),
                    $response->getReasonPhrase()
                ));

                exit;
            }
        }
    }

    //
    public function all() {
        return $this->getParams();
    }

    public function only($keys) {
        $keys = is_array($keys) === true ? $keys : func_get_args();

        return array_intersect_key(
            $this->getParams(),
            array_flip($keys)
        );
    }

    //
    public function rules() {
        throw new \RuntimeException('The FormRequest object must implement rules method.');
    }

    public function messages() {
        throw new \RuntimeException('The FormRequest object must implement messages method.');
    }

}
