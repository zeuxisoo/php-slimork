<?php
return [
    'driver'   => 'sendmail',     // smtp, sendmail

    // Smtp
    'host'       => '',
    'port'       => 25,        // 25, 587 etc
    'username'   => '',
    'password'   => '',
    'encryption' => 'tls',

    // Sendmail
    'sendmail' => '/usr/sbin/sendmail -bs',
];
