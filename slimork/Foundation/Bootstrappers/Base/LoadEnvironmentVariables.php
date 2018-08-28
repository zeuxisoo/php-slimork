<?php
namespace Slimork\Foundation\Bootstrappers\Base;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;
use Dotenv\Exception\InvalidFileException;
use Slimork\Foundation\App;

class LoadEnvironmentVariables {

    public function bootstrap(App $app) {
        try {
            (new Dotenv(
                $app->getEnvironmentPath(),
                $app->getEnvironmentFile()
            ))->load();
        } catch (InvalidPathException $e) {
            // Nothing to do, if not found .env in specified path, it will using the default settings file
        } catch (InvalidFileException $e) {
            exit('The environment file is invalid: '.$e->getMessage());
        }
    }

}
