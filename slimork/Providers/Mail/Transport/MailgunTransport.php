<?php
namespace Slimork\Providers\Mail\Transport;

use Swift_Mime_SimpleMessage;
use Mailgun\Mailgun;

class MailgunTransport extends Transport {

    protected $key;
    protected $domain;
    protected $endpoint;

    public function __construct($key, $domain, $endpoint = null) {
        $this->key      = $key;
        $this->domain   = $domain;
        $this->endpoint = $endpoint ?? 'https://api.mailgun.net';
    }

    protected function formatEmailAddress(array $to_emails) {
        return collect($to_emails)->map(function($username, $address) {
            return empty($username) === false  ? "$username <{$address}>" : $address;
        })->values()->implode(',');
    }

    // Implementation
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null) {
        if (empty($this->key) === true) {
            throw new \RuntimeException('Mailgun secret key cannot be empty');
        }

        $from    = $this->formatEmailAddress($message->getFrom());
        $to      = $this->formatEmailAddress($message->getTo());
        $subject = $message->getSubject();
        $body    = $message->getBody();

        $params = [
            'from'    => $from,
            'to'      => $to,
            'subject' => $subject,
        ];

        if ($message->getContentType() === 'text/html') {
            $params = array_merge($params, ['html' => $body]);
        }else{
            $params = array_merge($params, ['text' => $body]);
        }

        $mailgun  = Mailgun::create($this->key, $this->endpoint);
        $response = $mailgun->messages()->send($this->domain, $params);

        return $response->getId();
    }

}
