<?php
namespace Slimork\Foundation\Bootstrappers;

use Slimork\Foundation\App;

class RegisterMiddlewares {

    public function bootstrap(App $app) {
        foreach($app->getSetting('app')['middlewares'] as $middleware) {
            $app->add(new $middleware($app));
        }
    }

}
