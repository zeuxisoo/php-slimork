<?php
return [
    'driver' => 'bcrypt',   // bcrypt, argon2

    'bcrypt' => [
        'rounds' => 10,
    ],

    'argon2' => [
        'memory_cost' => 1024,
        'threads'     => 2,
        'time_cost'   => 2,
    ],
];
