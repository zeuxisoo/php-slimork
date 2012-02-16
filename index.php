<?php
error_reporting(E_ALL);
date_default_timezone_set("Asia/Hong_Kong");
define('IN_APPS', true);

// Define constant
define('WWW_ROOT', dirname(__FILE__));
define('APP_ROOT', dirname(__FILE__).'/app');
define('CACHE_ROOT', dirname(__FILE__).'/cache');
define('CONFIG_ROOT', dirname(__FILE__).'/config');
define('LIB_ROOT', dirname(__FILE__).'/lib');
define('LOG_ROOT', dirname(__FILE__).'/log');
define('VENDOR_ROOT', dirname(__FILE__).'/vendor');
define('HELPERS_ROOT', APP_ROOT.'/helpers');
define('ROUTERS_ROOT', APP_ROOT.'/routes');
define('MODELS_ROOT', APP_ROOT.'/models');
define('VIEWS_ROOT', APP_ROOT.'/views');

// Initial global variable
$config = array();

// Import config file
require_once CONFIG_ROOT.'/common.php';
require_once CONFIG_ROOT.'/database.php';

// Import vendor files
require_once VENDOR_ROOT.'/Slim/Slim.php';
require_once VENDOR_ROOT.'/Slim-Extras/Views/HaangaView.php';
require_once VENDOR_ROOT.'/idiorm.php';
require_once VENDOR_ROOT.'/pairs.php';

// Define auto load workflow
spl_autoload_register("auto_load");

function auto_load($class_name) {
	global $config;

	foreach(array('lib') as $folder) {
		$file_path = WWW_ROOT.'/'.$folder.'/'.strtolower($class_name).'.php';

		if (file_exists($file_path) === true && is_file($file_path) === true) {
			require_once $file_path;
		}
	}
}

// Configure database
ORM::configure($config['database']['dsn']);

if (empty($config['database']['username']) === false) {
	ORM::configure('username', $config['database']['username']);
	ORM::configure('password', $config['database']['password']);
}

if (substr(strtolower($config['database']['dsn']), 0, 5) === 'mysql') {
	ORM::configure('driver_options', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
}

// Initial slim framework
$app = new Slim(array(
	'mode'               => $config['common']['application_mode'],
	'view'               => new HaangaView(VENDOR_ROOT.'/Haanga', VIEWS_ROOT, CACHE_ROOT.'/views'),
	'templates.path'     => VIEWS_ROOT,
	'debug'              => $config['common']['enable_debug'],
	'log.enable'         => $config['common']['enable_log'],
	'log.path'           => LOG_ROOT,
	'cookies.lifetime'   => $config['common']['cookies_life_time'],
	'cookies.secret_key' => $config['common']['cookies_secret_key'],
));

// Auto import all routers, models, views file
$directories = array(ROUTERS_ROOT, MODELS_ROOT, VIEWS_ROOT, HELPERS_ROOT);

while (sizeof($directories)) {
	$directory = array_pop($directories);

	foreach(glob($directory."/*") as $file_path) {
		if (is_dir($file_path) === true) {
			array_push($directories, $file_path);
		}elseif (is_file($file_path) === true && preg_match("/\.(php|inc)$/", $file_path) == true) {
			require_once $file_path;
		}
	}
}

// Define helper variable
$headers = $app->request()->headers();
$seo_uri = $app->request()->getResourceUri();
$root_uri = $app->request()->getRootUri();
$protocol = isset($_SERVER['HTTPS']) === true ? 'https' : 'http';
$site_url = $protocol.'://'.$headers['host'].$root_uri;

// Set helper variable for control flow
$app->config('site_url', $site_url);

// Set helper variable for template
$app->view()->setData('site_url', $site_url);

// Boot application
$app->run();
?>