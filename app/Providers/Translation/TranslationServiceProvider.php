<?php
namespace App\Providers\Translation;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\MessageSelector;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use App\Contracts\ServiceProvider;

/**
 * Usage
 * =====
 *
 * Translation:
 *
 *      # In controller
 *      $this->translation->trans('Hello World!');
 *
 *      # In view
 *      {{ 'Hello World!' | trans }}
 *      {{ 'Hello World! My is %name%' | trans({'%name%': 'Cat'}) }}
 */
class TranslationServiceProvider extends ServiceProvider {

    public function register() {
        $translator = $this->setupTranslator($this->container->settings['app']['translation']);

        $this->container['view']->addExtension(new TranslationExtension($translator));

        $this->container['translation'] = function() use ($translator) {
            return $translator;
        };
    }

    public function setupTranslator($settings) {
        $translator = new Translator($settings['default_locale'], new MessageSelector());
        $translator->setFallbackLocales($settings['fallback_locale']);
        $translator->addLoader('array', new ArrayLoader());

        $directory_iterator = new \RecursiveDirectoryIterator(LANG_ROOT);
        $iterator_iterator  = new \RecursiveIteratorIterator($directory_iterator);
        $regex_iterator     = new \RegexIterator($iterator_iterator, '/^.+\.php$/i', \RecursiveRegexIterator::GET_MATCH);

        foreach($regex_iterator as $file_path => $items) {
            $locale_directory = explode(DIRECTORY_SEPARATOR, str_replace(LANG_ROOT, '', $file_path))[1];
            $locale_resource = require $file_path;

            $translator->addResource('array', $locale_resource, $locale_directory);
        }

        return $translator;
    }

}
