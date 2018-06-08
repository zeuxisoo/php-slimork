# CSRF

This service provider provided CSRF protection in the application

## Installation

1. Open the default application config file named `app.php`

        vim config/app.php

2. Add/Enable the following line

        'providers' => [
            ...
            Slimork\Providers\Csrf\CsrfServiceProvider::class,
            ...
        ]

3. Edit the default csrf config like store prefix, strength

        vim config/csrf.php

    - default prefix: `csrf`
    - default strength: `16`

## Usage

You can access the csrf service provider by the following code

**Base usage**

You can pass the generated token to view, and use it

For controller:

    $tags = $this->csrf->getTokenForHiddenInputTags();
    $tags = $this->csrf->getTokenForMetaTags();

For view:

{% raw %}
    {{ tags | raw }}
{% endraw %}

**Advanace usage**

Without controller, the view have global virables were named `csrf`, `csrf_metas` and `csrf_tags`

When using the `{{ csrf }}` variable, you need to custom the HTML to what you want, like

{% raw %}
    <input type="hidden" name="{{csrf.keys.name}}" value="{{csrf.name}}">
    <input type="hidden" name="{{csrf.keys.value}}" value="{{csrf.value}}">
{% endraw %}

But if you want to generate meta tags only, just call `{{ csrf_metas }}`, it will generate:


    <meta name='csrf_name' content='csrf_random_name'>
    <meta name='csrf_value' content='csrf_random_value'>

Also, In the form protection, you can using the `{{ csrf_tags }}` to do it, generated html like:

    <input type='hidden' name='csrf_name' value='csrf_random_name'>
    <input type='hidden' name='csrf_value' value='csrf_random_value'>

**Other usage**

If you want to control more

In controller:

    $csrf_tokens = $this->csrf->getTokens();

In view:

{% raw %}
    {% for name, value in csrf_tokens %}
        <input type="hidden" name="{{ name }}" value="{{ value }}">
    {% endfor %}

    {% for name, value in csrf_tokens %}
        <meta name="{{ name }}" content="{{ value }}">
    {% endfor %}
{% endraw %}
