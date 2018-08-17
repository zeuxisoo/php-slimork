<?php
namespace Slimork\Foundation\Bootstrappers\BuiltIn;

use Slimork\Foundation\App;

class RegisterServiceProviders {

    public function bootstrap(App $app) {
        $providers = [];

        foreach($app->getSetting('app')['providers'] as $provider) {
            $provider = new $provider($app);
            $provider->register();

            array_push($providers, $provider);
        }

        foreach($providers as $provider) {
            $provider->boot();
        }
    }

}
