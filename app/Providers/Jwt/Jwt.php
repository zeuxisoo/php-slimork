<?php
namespace App\Providers\Jwt;

use Firebase\JWT\JWT as FirebaseJWT;
use Carbon\Carbon;
use App\Helpers\StringHelper;

/**
 * Usage
 * =====
 *
 * Jwt
 *
 *      # Login and get token
 *      $token = $this->jwt->attempt([
 *          'username' => 'username',
 *          'password' => 'password'
 *      ]);
 *
 *      # Login and get token with custom playload
 *      $token = $this->jwt->attempt([
 *          'username' => 'username',
 *          'password' => 'password'
 *      ], [
 *          'custom' => 'payload',
 *          ...
 *          ...
 *      ]);
 *
 *      # Parse token
 *      $jwt = $this->jwt->parseToken($token)
 *
 *      # Get authenticated user by token
 *      $user = $jwt->authenticate();
 *
 *      # Get parsed token object
 *      $token = $jwt->getToken();
 */
class Jwt {

    protected $container;
    protected $auth       = null;

    protected $options = [
        'secret'      => '',
        'algorithm'   => 'HS256',
        'identifier'  => 'id',
        'ttl'         => 2880, // 2 days
    ];

    protected $payload = [];
    protected $token   = null;

    public function __construct($container, $options) {
        $this->container = $container;
        $this->auth      = $container['auth'];
        $this->options   = array_merge($this->options, $options);

        $this->payload = [
            // Issuer
            'iss'  => (string) $this->container['request']->getUri(),

            // Issued at: token generated time
            'iat'  => Carbon::now()->getTimestamp(),

            // Expire: with ttl
            'exp'  => Carbon::now()->addMinutes($this->options['ttl'])->getTimestamp(),

            // Not before
            'nbf'  => Carbon::now()->getTimestamp(),
        ];
    }

    public function attempt(array $credentials, array $custom_claims = []) {
        if ($this->auth->once($credentials) === false) {
            return false;
        }

        return $this->fromUser($this->auth->user(), $custom_claims);
    }

    public function fromUser($user, array $custom_claims = []) {
        return $this->encode($user, $custom_claims);
    }

    public function parseToken($token) {
        $this->token = $this->decode($token);

        return $this;
    }

    public function authenticate() {
        if ($this->token === null) {
            return null;
        }

        $user_id = $this->token->sub;

        if ($this->auth->onceUsingId($user_id) === null) {
            return false;
        }

        return $this->user();
    }

    public function getToken() {
        return $this->token;
    }

    public function user() {
        return $this->auth->user();
    }

    public function encode($user, array $custom_claims = []) {
        $this->payload = array_merge($this->payload, $custom_claims, [
            'sub' => $user->id,
            'jti' => md5(sprintf(
                '%s.%s',
                json_encode($this->payload),
                StringHelper::randomAlphaNumeric(20)
            ))
        ]);

        return FirebaseJWT::encode(
            $this->payload,
            $this->options['secret'],
            $this->options['algorithm']
        );
    }

    public function decode($token) {
        return FirebaseJWT::decode(
            $token,
            $this->options['secret'],
            ["HS256", "HS512", "HS384", "RS256"]
        );
    }

}
