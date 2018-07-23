<?php
namespace Slimork\Foundation;

/**
 * Usage
 * =====
 *
 * AliasLoader:
 *
 *     AliasLoader::getInstance(['DB' => Namespace\Path\To\Database::class])->register();
 */
class AliasLoader {

    protected static $instance = null;

    protected $aliases;

    protected $registered = false;

    public function __construct(array $aliases = []) {
        $this->aliases = $aliases;
    }

    public static function getInstance(array $aliases = []) {
        if (static::$instance === null) {
            return static::$instance = new static($aliases);
        }

        static::$instance->setAliases($aliases);

        return static::$instance;
    }

    public function setAliases(array $aliases) {
        $this->aliases = $aliases;
    }

    public function register() {
        if ($this->registered === false) {
            $this->prependToAutoloader();
            $this->registered = true;
        }
    }

    protected function prependToAutoloader() {
        spl_autoload_register([$this, 'load'], true, true);
    }

    public function load($alias) {
        if (isset($this->aliases[$alias]) === true) {
            return class_alias($this->aliases[$alias], $alias);
        }
    }

}
