# Cookie

The `cookie` service provider was provided easy way to control the cookie status in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Cookie\CookieServiceProvider::class,
            ...
        ]

3. Edit the default cookie config like store lifetime, path and so on

        vim config/cookie.php

    - default lifetime: `current time` + `3 hours`

## Usage

You can access the cookie service provider by the following code

- Set cookie

        $this->cookie->set('name', 'value');
        $this->cookie->set('name', 'value', [
            // Optional, This argument can overwrite the default cookie option when value was provided
        ]);

- Get cookie

        $this->cookie->get('name');

- Remove cookie

        $this->cookie->remove('name');

- Is value exists or not

        $this->cookie->has('name');
