<?php
namespace Slimork\Providers\Session;

class Segment {

    protected $name;
    protected $session_box;

    public function __construct($name) {
        $this->name = $name;

        // Initial the name scope in session
        if (isset($_SESSION[$name]) === false) {
            $_SESSION[$name] = [];
        }

        // Make the alias variable point to the name scope
        $this->session_box = &$_SESSION[$name];
    }

    public function set($key, $name) {
        $this->session_box[$key] = $name;
    }

    public function get($key, $default = null) {
        return $this->has($key) === true ? $this->session_box[$key] : $default;
    }

    public function has($key) {
        return array_key_exists($key, $this->session_box) === true;
    }

    public function remove($key) {
        if ($this->has($key) === true) {
            unset($this->session_box[$key]);
        }

        return $this;
    }

    public function pop($key) {
        if ($this->has($key) === true) {
            $value = $this->session_box[$key];

            $this->remove($key);

            return $value;
        }

        return null;
    }

    public function push($key, $value) {
        $this->session_box[$key][] = $value;

        return $this->get($key);
    }

    public function pull($key) {
        $items = $this->get($key);
        $item  = is_array($items) === true ? array_pop($this->session_box[$key]) : null;

        if ($this->isEmpty($key) === true) {
            $this->remove($key);
        }

        return $item;
    }

    public function isEmpty($key) {
        return empty($this->get($key)) === true;
    }

    public function all() {
        return $this->session_box;
    }

}
