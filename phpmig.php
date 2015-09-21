<?php
date_default_timezone_set('Asia/Hong_Kong');
define('IN_APPS', true);

define('WWW_ROOT', dirname(__FILE__));
define('PUBLIC_ROOT', WWW_ROOT.'/public');

require_once dirname(__FILE__).'/vendor/autoload.php';

use Pimple\Container;
use Phpmig\Adapter;

// Import config file
require_once dirname(__FILE__).'/config/common.php';
require_once dirname(__FILE__).'/config/database.php';

// Configure database
ORM::configure($config['database']['dsn']);

if (empty($config['database']['username']) === false) {
    ORM::configure('username', $config['database']['username']);
    ORM::configure('password', $config['database']['password']);
}

if (substr(strtolower($config['database']['dsn']), 0, 5) === 'mysql') {
    ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}

if (empty($config['database']['prefix']) === false) {
    Model::$auto_prefix_models = '\\'.$config['database']['prefix'].'\\';
}

//
$container = new Container();

$container['db'] = function(){
    return ORM::get_db();
};

$container['phpmig.adapter'] = function() use ($container) {
    return new Adapter\PDO\Sql($container['db'], 'migrations');
};

$container['phpmig.migrations_path'] = __DIR__ . DIRECTORY_SEPARATOR . 'migrations';

return $container;
