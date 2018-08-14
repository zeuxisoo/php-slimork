# MailDev

Simple way to testing mail service in development

## Requirement

The docker service must started

## Web interface

The default web GUI is `http://localhost:8081`

## Send by Sendmail

Edit the `mail.php` in config directory like

    <?php
    return [
        'driver'   => 'sendmail',

        ...
        ...

        'sendmail' => '/usr/sbin/sendmail -bs',
    ];


## Send by SMTP

Edit the `mail.php` in config directory like

    <?php
    return [
        'driver' => 'smtp',

        'host'       => 'maildev',
        'port'       => 25,
        'username'   => '',
        'password'   => '',
        'encryption' => '',

        ...
        ...
    ];
