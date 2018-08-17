<?php
namespace Slimork\Foundation\Bootstrappers\BuiltIn;

use Slimork\Foundation\App;
use Slimork\Foundation\AliasLoader;
use Slimork\Facades\Facade;

class RegisterFacades {

    public function bootstrap(App $app) {
        Facade::setFacadeApplication($app);

        AliasLoader::getInstance($app->getSetting('app')['aliases'])->register();
    }

}
