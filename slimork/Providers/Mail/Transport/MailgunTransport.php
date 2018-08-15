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

    // Reference to new doc: https://github.com/mailgun/mailgun-php/blob/master/doc/attachments.md
    protected function formatAttachments(array $attachments) {
        return collect($attachments)->map(function($attachment) {
            return [
                'filename'    => $attachment->getFilename(),
                'fileContent' => $attachment->getBody()
            ];
        })->toArray();
    }

    // Implementation
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null) {
        if (empty($this->key) === true) {
            throw new \RuntimeException('Mailgun secret key cannot be empty');
        }

        $from        = $this->formatEmailAddress($message->getFrom());
        $to          = $this->formatEmailAddress($message->getTo());
        $subject     = $message->getSubject();
        $body        = $message->getBody();
        $attachments = $this->formatAttachments($message->getChildren());

        $params = [
            'from'       => $from,
            'to'         => $to,
            'subject'    => $subject,
            'text'       => $body,
            'html'       => $body,
            'attachment' => $attachments,
        ];

        $mailgun  = Mailgun::create($this->key, $this->endpoint);
        $response = $mailgun->messages()->send($this->domain, $params);

        return $response->getId();
    }

}
