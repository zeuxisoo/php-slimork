<?php
return [

    'mailgun' => [
        'secret'   => env('MAILGUN_SECRET', ''),
        'domain'   => env('MAILGUN_DOMAIN', ''),
        'endpoint' => env('MAILGUN_ENDPOINT', 'https://api.mailgun.net'),
    ],

];
