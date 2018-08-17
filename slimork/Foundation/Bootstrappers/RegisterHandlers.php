<?php
namespace Slimork\Foundation\Bootstrappers;

use Slimork\Foundation\App;

class RegisterHandlers {

    public function bootstrap(App $app) {
        foreach($app->getSetting('app')['handlers'] as $handler) {
            $handler = new $handler($app);
            $handler->register();
        }
    }

}
