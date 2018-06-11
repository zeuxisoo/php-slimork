# Session

This service provider provided basic session management function in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Session\SessionServiceProvider::class,
            ...
        ]

3. Edit the default session config like store name, lifetime, path and so on

        vim config/session.php

    - default name: `_sk`
    - default lifetime: `7200` second (= `2` hours)

## Usage

You can access the session service provider by the following code

**Set key and value**

    $this->session->set('key', 'value')

**Get value**

    $this->session->get('key')

**Check the value is or not exists**

    $this->session->has('key2')

**Remove value**

remove this value first before retrieve and reutrn value

    $this->session->remove('key')

**Pop value**

retrieve this value first, then delete it and return the retrieved value

    $this->session->pop('key');

**Push value to array item**

the key must not exist

    $this->session->push('key3', 'a'); // return value: ['a']
    $this->session->push('key3', 'b'); // return value: ['a', 'b']
    $this->session->push('key3', 'c'); // return value: ['a', 'b', 'c']

**Pull value from array item**

    $this->session->pull('key3'); // return value: c
    $this->session->pull('key3'); // return value: b
    $this->session->pull('key3'); // return value: a
