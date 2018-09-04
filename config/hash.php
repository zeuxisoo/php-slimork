<?php
return [
    'driver' => env('HASH_DRIVER', 'bcrypt'),   // bcrypt, argon2

    'bcrypt' => [
        'rounds' => env('HASH_BCRYPT_ROUNDS', 10),
    ],

    'argon2' => [
        'memory_cost' => env('HASH_ARGON2_MEMORY_COST', 1024),
        'threads'     => env('HASH_ARGON2_THREADS', 2),
        'time_cost'   => env('HASH_ARGON2_TIME_COST', 2),
    ],
];
