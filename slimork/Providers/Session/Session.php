<?php
namespace Slimork\Providers\Session;



class Session {

    protected $settings;

    protected $options = [
        'name'     => 'PHPSESSID',
        'lifetime' => 7200,
        'path'     => null,
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
        'handler'  => null,
        'ini_sets' => []
    ];

    public function __construct($container) {
        $this->settings = array_merge($this->options, $container->get('settings')['session']);

        // Set ini settings
        foreach($this->settings['ini_sets'] as $name => $value) {
            ini_set("session.".$name, $value);
        }
    }

    public function isStarted() {
        return session_status() !== PHP_SESSION_NONE;
    }

    public function start() {
        session_set_cookie_params(
            $this->settings['lifetime'],
            $this->settings['path'],
            $this->settings['domain'],
            $this->settings['secure'],
            $this->settings['httponly']
        );

        session_name($this->settings['name']);

        if ($this->isStarted() === false) {
            session_start();
        }

        if ($this->settings['handler'] !== null) {
            if ($this->settings['handler'] instanceof SessionHandlerInterface) {
                session_set_save_handler(new $this->settings['handler'], true);
            }else{
                throw new \RuntimeException('The session handler must be instance of SessionHandlerInterface');
            }
        }
    }

    public function set($key, $name) {
        $_SESSION[$key] = $name;
    }

    public function get($key, $default = null) {
        return $this->has($key) === true ? $_SESSION[$key] : $default;
    }

    public function has($key) {
        return array_key_exists($key, $_SESSION) === true;
    }

    public function remove($key) {
        if ($this->has($key) === true) {
            unset($_SESSION[$key]);
        }

        return $this;
    }

    public function pop($key) {
        if ($this->has($key) === true) {
            $value = $_SESSION[$key];

            $this->remove($key);

            return $value;
        }

        return null;
    }

    public function push($key, $value) {
        $_SESSION[$key][] = $value;

        return $this->get($key);
    }

    public function pull($key) {
        $items = $this->get($key);
        $item  = is_array($items) === true ? array_pop($_SESSION[$key]) : null;

        if ($this->isEmpty($key) === true) {
            $this->remove($key);
        }

        return $item;
    }

    public function isEmpty($key) {
        return empty($this->get($key)) === true;
    }

    public function all() {
        return $_SESSION;
    }

}
