# Redirection

This service provider provided redirect action in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Redirection\RedirectionServiceProvider::class,
            ...
        ]

## Usage

Redirect to path like `/` , `/admin`

    $this->redirect->to('/admin');

Redirect to any url like `https://google.com/`

    $this->redirect->away('http://google.com/');

set custom type for message

    $this->flash->setTypeMessage('type', 'message');

Redirect to named route like `home.index`

    this->redirect->route('home.index');

Redirect back to previous page

    $this->redirect->back();

Redirect back to previous page with input data

    $this->redirect->back()->withRequestParams();

Redirect back to previous page with input data, custom header and so on

    $this->redirect->back()->withRequestParams()->withHeader('X-Hello', 'Params included');

The `old_param()` methods can help you to show the previous form input data

> E.g. The form had validation error, you must redirect back to previous page to show the error message, and the user input must re-populate in form.

    old_param('name')
    old_param('name', 'default_value')

For example, Default show the user inputed data when redirect back was triggered

{% raw %}
    <input type="text" name="username" value="{{ old_param('username') }}">
    <input type="text" name="password" value="{{ old_param('password') }}">
{% endraw %}

Redirect with flash message

    $this->redirect->to('/path/to/page')->withError('message')
    $this->redirect->route('page.index')->withMessage('message')
    $this->redirect->back()->withTypeMessage('erorr|success|custom', 'message')
