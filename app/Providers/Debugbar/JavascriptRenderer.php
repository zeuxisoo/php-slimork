<?php
namespace App\Providers\Debugbar;

use DebugBar\DebugBar;
use DebugBar\JavascriptRenderer as BaseJavascriptRenderer;

class JavascriptRenderer extends BaseJavascriptRenderer {

    protected $app;

    public function __construct(DebugBar $debug_bar, $base_url = null, $base_path = null) {
        parent::__construct($debug_bar, $base_url, $base_path);

        $this->cssVendors['fontawesome'] = __DIR__.'/Resources/vendor/font-awesome/style.css';
    }

    public function setApp($app) {
        $this->app = $app;
    }

    protected function modifiedTime($type) {
        $files = $this->getAssets($type);
        $latest = 0;

        foreach ($files as $file) {
            $mtime = filemtime($file);
            if ($mtime > $latest) {
                $latest = $mtime;
            }
        }

        return $latest;
    }

    public function dumpAssetsToString($type) {
        $files = $this->getAssets($type);

        $content = '';

        foreach ($files as $file) {
            $content .= file_get_contents($file) . "\n";
        }

        return $content;
    }

    // @overwrite
    public function renderHead() {
        $container = $this->app->getContainer();

        $js_modified  = $this->modifiedTime('js');
        $css_modified = $this->modifiedTime('css');

        $html   = [];

        // css
        $html[] = sprintf(
            '<link rel="stylesheet" type="text/css" href="%s?%s">',
            $container['router']->pathFor('debugbar.assets.css'),
            $css_modified
        );

        // js
        $html[] = sprintf(
            '<script type="text/javascript" src="%s?%s"></script>',
            $container['router']->pathFor('debugbar.assets.js'),
            $js_modified
        );

        if ($this->isJqueryNoConflictEnabled()) {
            $html[] = '<script type="text/javascript">jQuery.noConflict(true);</script>';
        }

        return implode("\n", $html);
    }


}
