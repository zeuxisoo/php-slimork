<?php
if (defined("IN_APPS") === false) exit("Access Dead");

class Permission {

	public static function create_key($username, $password, $cookies_secret_key) {
		$password = md5($password);
		$auth_key = sha1($username.$password.$cookies_secret_key);
		$auth_string = Permission::make_auth("$username\t$password\t$auth_key");
		return $auth_string;
	}

	public static function make_auth($string, $operation = 'ENCODE') {
		$string = $operation == 'DECODE' ? base64_decode($string) : base64_encode($string);
		return $string;
	}

	public static function is_admin() {
		global $config;

		$admin_auth = isset($_COOKIE['auth_key']) ? $_COOKIE['auth_key'] : "";

		if (isset($admin_auth) === true && empty($admin_auth) === false) {
			list($admin_username, $admin_password, $admin_auth_key) = explode("\t", self::make_auth($admin_auth, "DECODE"));

			$_SESSION['username'] = $admin_username;

			return sha1($admin_username.$admin_password.$config['common']['cookies_secret_key']) === $admin_auth_key;
		}

		return false;
	}

	public static function need_admin() {
		if (self::is_admin() === false) {
			$_SESSION['username'] = "";
			$_SESSION['error'] = "請重新登入!";
			header("Location: ./");
			exit;
		}
	}

}
?>