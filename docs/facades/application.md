# Application

In this level, We have providerd default container facade object to you.

## Facades

**App**

return the Slim object instance like `$app`

**Container**

return the Slim container like `$app->getContainer()`

**Router**

return the router from Slim container like `$app->getContainer()->get('router')`

**Request**

return the request from Slim container like `$app->getContainer()->get('request')`

**Response**

return the response from Slim container like `$app->getContainer()->get('response')`

**Settings**

return the settings from Slim container like `$app->getContainer()->get('settings')`

extra methods:

    Settings::get('key');
    Settings::set('key', 'value');
