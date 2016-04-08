<?php
namespace App\Providers\Logger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Log:
 *
 *      $this->logger->addInfo('message');
 */
class LoggerServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['logger'] = function($c) {
            $logger       = new Logger('SIMPLE_WORK');
            $file_handler = new StreamHandler(STORAGE_ROOT.'/logs/'.date('Y-m-d').'.log');

            $logger->pushHandler($file_handler);

            return $logger;
        };
    }

}
