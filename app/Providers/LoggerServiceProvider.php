<?php
namespace App\Providers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Constracts\ServiceProvider;

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
