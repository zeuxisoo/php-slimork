# Mail

This service provider provided basic send mail function in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Mail\MailServiceProvider::class,
            ...
        ]

3. Edit the default mail config like send mail method, server, username, password and port

        vim config/mail.php

    - default send mail method: `sendmail`

## Prerequisites

If you are using the `mailgun` driver, you must install the Mailgun related package first, Please add the following lines to your `compose.json` file

    "mailgun/mailgun-php": "2.6.*",
    "php-http/guzzle6-adapter": "1.1.*"

## Usage

You can access the mail service provider by the following code

**Send mail (one recipient and sender)**

    $this->mail
        ->subject('subject')
        ->from('email')
        ->to('email')
        ->body('content')
        ->send();

**Send mail (one recipient and sender are named)**

    $this->mail
        ...
        ->from(['email' => 'name'])
        ->to(['email' => 'name'])
        ...
        ->send();

**Send mail (many recipient and sender)**

    $this->mail
        ...
        ->from(['email', 'email'])
        ->to(['email', 'email'])
        ...
        ->send();

**Send mail (many recipient and sender are named)**

    $this->mail
        ...
        ->from(['email' => 'name', 'email' => 'name'])
        ->to(['email' => 'name', 'email' => 'name'])
        ...
        ->send();

**Send mail with attachments**

    $this->mail
        ...
        ...
        ->attach(['file_paths', 'file_paths'])
        ->send();

**Send mail (content is plain text only, default is `text/html`)**

    $this->mail
        ...
        ...
        ->body('content', 'text/plain')
        ->send();
