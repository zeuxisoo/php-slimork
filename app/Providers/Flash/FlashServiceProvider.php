<?php
namespace App\Providers\Flash;

use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Flash
 *
 * Set message
 *
 *      # simple method
 *      $this->flash->error('message');
 *      $this->flash->success('message');
 *
 *      # getter and setter methods
 *      $this->flash->setError('message');
 *      $this->flash->setSuccess('message');
 *
 *      # other methods
 *      $this->flash->setTypeMessage('type', 'message');
 *
 * Get message
 *
 *      # simple method
 *      $this->flash->error();
 *      $this->flash->success();
 *
 *      # getter and setter methods
 *      $this->flash->getError();
 *      $this->flash->getSuccess();
 *
 *      # otehr methods
 *      $this->flash->getTypeMessage('type');
 *
 */
class FlashServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['flash'] = function() {
            return new Flash();
        };
    }

}
