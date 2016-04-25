<?php
namespace App\Providers\Debugbar;

use DebugBar\StandardDebugBar as BaseStandardDebugbar;

class StandardDebugbar extends BaseStandardDebugbar {

    protected $app;

    public function __construct($app) {
        parent::__construct();

        $this->app = $app;
    }

    public function setApp($app) {
        $this->app = $app;
    }

    public function getJavascriptRenderer($base_url = null, $base_path = null) {
        if ($this->jsRenderer === null) {
            $this->jsRenderer = new JavascriptRenderer($this, $base_url, $base_path);
            $this->jsRenderer->setApp($this->app);
        }
        return $this->jsRenderer;
    }

}
