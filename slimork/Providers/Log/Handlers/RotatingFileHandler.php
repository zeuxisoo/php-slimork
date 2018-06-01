<?php
namespace Slimork\Providers\Log\Handlers;

use Monolog\Handler\RotatingFileHandler as MonologRotatingFileHandler;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Formatter\LineFormatter;

class RotatingFileHandler extends LogHandler {

    public function getFilename() {
        return $this->settings['path'].'/'.$this->name.'.log';
    }

    public function getHandler() {
        $max_file = $this->settings['max_file'];

        $handler = new MonologRotatingFileHandler($this->getFilename(), $max_file, $this->getLevel());
        $handler->setFormatter(new LineFormatter(
            LineFormatter::SIMPLE_FORMAT, NormalizerFormatter::SIMPLE_DATE, true, true
        ));

        return $handler;
    }

}
