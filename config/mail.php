<?php
return [
    'driver'   => env('MAIL_DRIVER', 'sendmail'),     // smtp, sendmail, mailgun

    // Smtp
    'host'       => env('MAIL_HOST', ''),
    'port'       => env('MAIL_PORT', 25),        // 25, 587 etc
    'username'   => env('MAIL_USERNAME', ''),
    'password'   => env('MAIL_PASSWORD', ''),
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    // Sendmail
    'sendmail' => '/usr/sbin/sendmail -bs',
];
