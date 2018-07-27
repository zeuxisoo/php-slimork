<?php
namespace Slimork\Providers\Flash;

use Slimork\Contracts\ServiceProvider;

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
 * Other methods
 *
 *      # check the type of message is or not exists
 *      $this->flash->has('type');
 *
 * In view like:
 *
 *     {% if has_flash('error') %}
 *         <div class="alert alert-error alert-danger">
 *             <strong>Error!</strong>&nbsp;{{ flash('error') }}
 *         </div>
 *     {% endif %}
 */
class FlashServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('flash', function($container) {
            return new Flash();
        });
    }

    public function boot() {
        if ($this->container->has('view') === true) {
            $this->container->get('view')->addExtension(new ViewExtension($this->container));
        }
    }

}
