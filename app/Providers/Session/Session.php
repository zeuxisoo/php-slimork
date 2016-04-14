<?php
namespace App\Providers\Session;

/**
 * Usage
 * =====
 *
 * Session:
 *
 *      # Set key and value
 *      $this->session->set('key', 'value')
 *
 *      # Get value
 *      $this->session->get('key')
 *
 *      # Is value exists or not
 *      $this->session->has('key2')
 *
 *      # Remove value
 *      $this->session->remove('key')
 *
 *      # Pop value
 *      $this->session->pop('key');
 *
 *      # Push value to key
 *      $this->session->push('key3', 'a'); // ['a']
 *      $this->session->push('key3', 'b'); // ['a', 'b']
 *      $this->session->push('key3', 'c'); // ['a', 'b', 'c']
 *
 *      # Pull value from key
 *      $this->session->pull('key3'); // c
 *      $this->session->pull('key3'); // b
 *      $this->session->pull('key3'); // a
 */
class Session {

    protected $session;

    public function __construct() {
        $this->session = &$_SESSION;
    }

    public function set($key, $name) {
        $this->session[$key] = $name;
    }

    public function get($key, $default = null) {
        return $this->has($key) ? $this->session[$key] : $default;
    }

    public function has($key) {
        return array_key_exists($key, $this->session) === true;
    }

    public function remove($key) {
        if ($this->has($key) === true) {
            unset($this->session[$key]);
        }

        return $this->get($key);
    }

    public function pop($key) {
        if ($this->has($key) === true) {
            $value = $this->get($key);

            $this->remove($key);

            return $value;
        }

        return null;
    }

    public function push($key, $value) {
        $this->session[$key][] = $value;

        return $this->get($key);
    }

    public function pull($key) {
        $items = $this->get($key);
        $item  = is_array($items) === true ? array_pop($this->session[$key]) : null;

        if ($this->isEmpty($key) === true) {
            $this->remove($key);
        }

        return $item;
    }

    public function isEmpty($key) {
        return empty($this->session[$key]) === true;
    }

}
