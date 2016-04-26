<?php
namespace App\Providers\Session;

use Aura\Session\SessionFactory;

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
    protected $segment = "App\Providers\Session\Segment\Default";

    protected $options = [
        'name'     => 'PHPSESSID',
        'lifetime' => 7200,
        'path'     => null,
        'domain'   => null,
        'secure'   => false,
        'httponly' => true,
    ];

    public function __construct($container) {
        $settings = array_merge($this->options, $container['settings']['app']['session']);

        $session = (new SessionFactory())->newInstance($_COOKIE);
        $session->setCookieParams($settings);
        $session->setName($settings['name']);

        $this->session = $session;
    }

    public function instance() {
        return $this->session;
    }

    public function segment($name = "") {
        if (empty($name) === false) {
            $this->segment = $name;
        }

        return $this->session->getSegment($this->segment);
    }

    public function set($key, $name) {
        $this->segment()->set($key, $name);
    }

    public function get($key, $default = null) {
        return $this->has($key) ? $this->segment()->get($key) : $default;
    }

    public function has($key) {
        return array_key_exists($key, $_SESSION[$this->segment]) === true;
    }

    public function remove($key) {
        if ($this->has($key) === true) {
            unset($_SESSION[$this->segment][$key]);
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
        $_SESSION[$this->segment][$key][] = $value;

        return $this->get($key);
    }

    public function pull($key) {
        $items = $this->get($key);
        $item  = is_array($items) === true ? array_pop($_SESSION[$this->segment][$key]) : null;

        if ($this->isEmpty($key) === true) {
            $this->remove($key);
        }

        return $item;
    }

    public function isEmpty($key) {
        return empty($this->segment()->get($key)) === true;
    }

    public function all($segment = "") {
        return empty($segment) === true ? $_SESSION[$this->segment] : $_SESSION[$segment];
    }


}
