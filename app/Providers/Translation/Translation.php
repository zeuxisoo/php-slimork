<?php
namespace App\Providers\Translation;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\ArrayLoader;

class Translation {

    protected static $instance = null;

    protected $translator;

    public static function getInstance($settings) {
        if (static::$instance === null) {
            static::$instance = new static($settings);
        }

        return static::$instance;
    }

    public function __construct($settings) {
        $this->translator = new Translator($settings['default_locale'], new MessageSelector());
        $this->translator->setFallbackLocales($settings['fallback_locale']);
        $this->translator->addLoader('array', new ArrayLoader());

        $directory_iterator = new \RecursiveDirectoryIterator(LANG_ROOT);
        $iterator_iterator  = new \RecursiveIteratorIterator($directory_iterator);
        $regex_iterator     = new \RegexIterator($iterator_iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach($regex_iterator as $file_path => $items) {
            $locale_directory = explode(DIRECTORY_SEPARATOR, str_replace(LANG_ROOT, '', $file_path))[1];
            $locale_resource = require $file_path;

            $this->translator->addResource('array', $locale_resource, $locale_directory);
        }
    }

    public function translator() {
        return $this->translator;
    }

}
