# Flash

This service provider provided flash message in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Csrf\FlashServiceProvider::class,
            ...
        ]

## Usage

You can access the flash service provider by the following code

**Set the message**

    $this->flash->error('message');
    $this->flash->success('message');

using the setter

    $this->flash->setError('message');
    $this->flash->setSuccess('message');

set custom type for message

    $this->flash->setTypeMessage('type', 'message');

**Get the message**

    $this->flash->error();
    $this->flash->success();

using the getter

    $this->flash->getError();
    $this->flash->getSuccess();

get custom message by type

    $this->flash->getTypeMessage('type');

**Get the message in view**

This service provider was provided two view functions were named

- `has_flash('type')`: Check the type of message is or not exists
- `flash('type')`: Get the type of message from flash object and then remove it

And the code looks like

{% raw %}
    {% if has_flash('type') %}
        <div class="alert alert-type alert-color">
            <strong>Oh!</strong>&nbsp;{{ flash('type') }}
        </div>
    {% endif %}
{% endraw %}
