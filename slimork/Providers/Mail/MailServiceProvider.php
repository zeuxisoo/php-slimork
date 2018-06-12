<?php
namespace Slimork\Providers\Mail;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Mail:
 *
 *      $this->mail->subject('subject')->from('[emails]')->to('[emails]')->body('content')->send();
 *
 */
class MailServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('mail', function($container) {
            return new Mail($container);
        });
    }

}
