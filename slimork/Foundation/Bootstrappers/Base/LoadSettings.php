<?php
namespace Slimork\Foundation\Bootstrappers\Base;

use Slimork\Foundation\App;

class LoadSettings {

    public function bootstrap(App $app) {
        $slim_config  = require CONFIG_ROOT.'/slim.php';
        $final_config = [
            'settings' => $slim_config
        ];

        // Merge all config in settings namespace
        foreach(glob(CONFIG_ROOT."/*.php") as $file_path) {
            $file_name = basename($file_path, ".php");

            if ($file_name !== 'slim') {
                $final_config['settings'][$file_name] = require_once $file_path;
            }
        }

        // Make the slim config in global with `settings` prefix
        foreach($slim_config as $name => $value) {
            $final_config['settings.'.$name] = $value;
        }

        date_default_timezone_set($final_config['settings']['app']['timezone']);

        $app->setSettings($final_config);
    }

}
