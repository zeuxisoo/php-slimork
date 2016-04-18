<?php
namespace App\Providers\Auth;

use App\Helpers\StringHelper;
use App\Models\User;

/**
 * Usage
 * =====
 *
 * Auth
 *
 *      # Login
 *      $login = $this->auth->attempt([
 *          'username' => 'username',
 *          'password' => 'password'
 *      ]);
 *
 *      # Login and remember me options
 *      $login = $this->auth->attempt([
 *          'username' => 'username',
 *          'password' => 'password'
 *      ], true);
 *
 *      # Logout
 *      $this->auth->logout();
 *
 *      # Current user
 *      $this->auth->user();
 *
 *      # Login once without session and cookie
 *      $this->auth->once([
 *          'username' => 'username',
 *          'password' => 'password'
 *      ]);
 */
class Auth {

    protected $container;
    protected $user;
    protected $once_user;

    public function __construct($container) {
        $this->container = $container;
    }

    // Just make login action without store session and cookie
    public function once($credentials) {
        if ($this->attempt($credentials, false, false) === true) {
            $this->setUser($this->once_user);

            return true;
        }

        return false;
    }

    public function attempt($credentials, $remember = false, $login = true) {
        $user = $this->once_user = $this->findUserByCredentials($credentials);

        if ($this->isValidCredentials($user, $credentials) === true) {
            if ($login) {
                $this->login($user, $remember);
            }

            return true;
        }

        return false;
    }

    public function findUserByCredentials($credentials) {
        if (empty($credentials) === true) {
            return null;
        }else{
            $user  = new User();
            $query = $user->newQuery();

            foreach($credentials as $field => $value) {
                if (strtolower($field) !== 'password') {
                    $query->where($field, $value);
                }
            }

            return $query->first();
        }
    }

    public function isValidCredentials($user, $credentials) {
        return $user !== null && $this->container->hash->check($credentials['password'], $user->password);
    }

    public function login($user, $remember = false) {
        // Set session
        $this->updateSession($user->id);

        // Create remeber token
        if ($remember) {
            if (empty($user->remember_token) === true) {
                $this->refreshRememberTokenInUserTable();
            }
            $this->rememberAtCookie($user);
        }

        // Store user
        $this->setUser($user);
    }

    public function updateSession($user_id) {
        $name = $this->getLoginTokenName();

        $this->container->session->set($name, $user_id);
    }

    public function rememberAtCookie($user) {
        $name  = $this->getRememberTokenName();
        $value = $user->id.'|'.$user->remember_token;

        $this->container->cookie->set($name, $value);
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function user() {
        if ($this->user !== null) {
            return $this->user;
        }else{
            $user = null;

            // Try to find user by session
            $user_id = $this->container->session->get($this->getLoginTokenName());

            if ($user_id !== null) {
                $user = User::find($user_id);
            }

            // Try to find user by remember token
            if ($user === null) {
                $remember_token = $this->container->cookie->get($this->getRememberTokenName());

                if ($this->isValidRememberToken($remember_token) === true) {
                    list($user_id, $remember_token) = explode('|', $remember_token, 2);

                    $user = User::where('remember_token', $remember_token)->find($user_id);

                    if ($user !== null) {
                        $this->updateSession($user->id);
                    }
                }
            }

            $this->user = $user;

            return $user;
        }
    }

    public function isValidRememberToken($token) {
        if (is_string($token) === false || StringHelper::contains($token, '|') === false) {
            return false;
        }else{
            $segments = explode('|', $token);

            return count($segments) === 2 && trim($segments[0]) !== '' && trim($segments[1]) !== '';
        }
    }

    public function getLoginTokenName() {
        return 'login_token_'.hash('sha256', static::class);
    }

    public function getRememberTokenName() {
        return 'remember_token_'.hash('sha256', static::class);
    }

    public function logout() {
        $user = $this->user();

        // Refresh remember token in related user table,
        // but do not update to cookie
        if ($this->user !== null) {
            $this->refreshRememberTokenInUserTable($user);
        }

        $this->user = null;

        $this->container->session->remove($this->getLoginTokenName());
    }

    public function refreshRememberTokenInUserTable($user) {
        $user->remember_token = StringHelper::random();
        $user->save();
    }

    public function guest() {
        return $this->user() === null;
    }

}
