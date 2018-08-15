<?php
namespace Slimork\Providers\Mail;

use Swift_SmtpTransport;
use Swift_SendmailTransport;
use Swift_Message;
use Swift_Attachment;
use Swift_Mailer;

class Mail {

    protected $transport;
    protected $subject;
    protected $from_emails;
    protected $to_emails;
    protected $body;
    protected $body_format = "text/html";
    protected $attachments = [];

    public function __construct($container) {
        $mail     = $container->get('settings')['mail'];
        $services = $container->get('settings')['services'];

        $transport = null;
        switch($mail['driver']) {
            case 'smtp':
                $transport = new Swift_SmtpTransport($mail['host'], $mail['port']);
                $transport->setEncryption($mail['encryption']);
                $transport->setUsername($mail['username']);
                $transport->setPassword($mail['password']);
                break;
            case 'mailgun':
                $transport = new Transport\MailgunTransport(
                    $services['mailgun']['secret'],
                    $services['mailgun']['domain'],
                    $services['mailgun']['endpoint'] ?? null
                );
                break;
            default:
                $transport = new Swift_SendmailTransport($mail['sendmail']);
                break;
        }

        $this->transport = $transport;
    }

    public function subject($subject) {
        $this->subject = $subject;

        return $this;
    }

    public function from($emails) {
        $this->from_emails = $emails;

        return $this;
    }

    public function to($emails) {
        $this->to_emails = $emails;

        return $this;
    }

    public function body($body, $format = 'text/html') {
        $this->body        = $body;
        $this->body_format = $format;

        return $this;
    }

    public function attach(array $attachments = []) {
        $this->attachments = $attachments;

        return $this;
    }

    public function send() {
        $message = new Swift_Message($this->subject);
        $message->setFrom($this->from_emails);
        $message->setTo($this->to_emails);
        $message->setBody($this->body, $this->body_format);

        if (empty($this->attachments) === false) {
            foreach($this->attachments as $attachment) {
                $message->attach(
                    Swift_Attachment::fromPath($attachment)
                );
            }
        }

        $mailer = new Swift_Mailer($this->transport);
        $result = $mailer->send($message);

        return $result;
    }

}
