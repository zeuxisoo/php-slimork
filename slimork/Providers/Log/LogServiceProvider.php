<?php
namespace Slimork\Providers\Log;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Log
 *
 *      echo $this->log->debug('message');
 *      echo $this->log->info('message');
 *      echo $this->log->notice('message');
 *      echo $this->log->warn('message');
 *      echo $this->log->warning('message');
 *      echo $this->log->error('message');
 *      echo $this->log->critical('message');
 *      echo $this->log->alert('message');
 *      echo $this->log->emergency('message');
 *
 */
class LogServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('log', function($c) {
            $settings = $c->get('settings');

            return new Logger('slimork', $settings['logger']);
        });
    }

}
