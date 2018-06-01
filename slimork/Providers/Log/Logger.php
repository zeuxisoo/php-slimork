<?php
namespace Slimork\Providers\Log;

use Monolog\Logger as MonoLogger;

class Logger extends Monologger {

    public function __construct($name, $settings) {
        parent::__construct($name);

        // Set process handler
        foreach($settings['processors'] as $processor) {
            $this->pushProcessor(new $processor);
        }

        // Set log handler
        foreach($settings['handlers'] as $key => $info) {
            $handler_name    = $info['handler'];
            $handler_options = array_merge($settings, $info['options']);

            $handler = new $handler_name($name.'.'.$key, $handler_options);

            $this->pushHandler($handler->getHandler());
        }

        return $this;
    }

}
