<?php
namespace Slimork\Providers\Session;

use RuntimeException;
use BadMethodCallException;

class Session {

    protected $segment = __class__;
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
                throw new RuntimeException('The session handler must be instance of SessionHandlerInterface');
            }
        }

        $this->segment = new Segment($this->segment);
    }

    public function __call($name, array $arguments) {
        if (method_exists($this->segment, $name) === false) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $name
            ));
        }

        return call_user_func_array([$this->segment, $name], $arguments);
    }

}
