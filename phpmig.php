<?php
require_once dirname(__FILE__).'/vendor/autoload.php';

use Pimple\Container;
use Phpmig\Adapter;

$container = new Container();

$container['db'] = function(){
    return ORM::get_db();
};

$container['phpmig.adapter'] = function() use ($container) {
    return new Adapter\PDO\Sql($container['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;
