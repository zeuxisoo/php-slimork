<?php
return [
    'driver'   => 'sendmail',     // smtp, sendmail

    'host'     => '',
    'port'     => 25,             // 25, 587 etc
    'username' => '',
    'password' => '',

    'sendmail' => '/usr/sbin/sendmail -bs',
];
