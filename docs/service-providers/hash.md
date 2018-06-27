# Hash

This service provider can provide secure BCrypt and Argon2 hashing for store password

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Hash\HashServiceProvider::class,
            ...
        ]

3. Edit the default mail config like hash algorithm and related algorithm settings.

        vim config/hash.php

    - default hashing algorithm: `bcrypt`

## Usage

You can access the hash service provider by the following code
    Base Usage**

Create hashed string

    $this->hash->make('string');

Check the hashed string is or not matched

    $this->hash->check('string', 'hashed_string');

Rehash the value

    $this->hash->needsRehash('hashed_string');

**Overwrite default bcrypt options**

Create hashed string (cost: 12)

    $this->hash->make('string', ['cost' => 10]);

Rehash the value (cost: 12)

    $this->hash->needsRehash('hashed_string', ['cost' => 10]);

**Overwrite default argon2 options**

Create hashed string (memory: 2046, threads: 4, time: 4)

    $this->hash->make('string', [
        'memory_cost' => 2046,
        'threads'     => 4,
        'time_cost'   => 4,
    ]);

Rehash the value (memory: 2046, threads: 4, time: 4)

    $this->hash->needsRehash('hashed_string', [
        'memory_cost' => 2046,
        'threads'     => 4,
        'time_cost'   => 4,
    ]);
