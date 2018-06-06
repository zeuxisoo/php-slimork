<?php
namespace Slimork\Providers\Cookie;

use DateTime;
use Psr\Container\ContainerInterface;

class Cookie {

    protected $container;
    protected $cookie;

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        $this->cookie    = $_COOKIE;
    }

    public function set($name, $value, $options = []) {
        $options = array_merge([
            'expires'   => new DateTime('+1 hours'),
            'path'      => '/',
            'domain'    => null,
            'secure'    => false,
            'http_only' => true,
        ], $this->container->get('settings')['cookie'], $options);

        if ($options['expires'] instanceof DateTime) {
            $options['expires'] = $options['expires']->getTimestamp();
        }

        setcookie(
            $name, $value,
            $options['expires'], $options['path'], $options['domain'], $options['secure'], $options['http_only']
        );
    }

    public function has($name) {
        return array_key_exists($name, $_COOKIE);
    }

    public function get($name, $default = null) {
        return $this->has($name) === true ? $_COOKIE[$name] : $default;
    }

    public function remove($name) {
        if ($this->has($name) === true) {
            unset($_COOKIE[$name]);

            $this->set($name, "", [
                'expires' => new DateTime('-10 years')
            ]);
        }
    }

}
