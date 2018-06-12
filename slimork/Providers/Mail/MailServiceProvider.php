<?php
namespace Slimork\Providers\Mail;

use Slimork\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Mail:
 *
 *      $this->mail->subject('subject')->from('email')->to('email')->body('content')->send();
 *
 *      $this->mail->subject('subject')->from('email')->to('email')->body('content')->attach('[file_paths]')->send();
 *
 *      $this->mail->subject('subject')->from('[emails]')->to('[emails]')->body('content')->attach('[file_paths]')->send();
 *
 */
class MailServiceProvider extends ServiceProvider {

    public function register() {
        $this->container->set('mail', function($container) {
            return new Mail($container);
        });
    }

}
