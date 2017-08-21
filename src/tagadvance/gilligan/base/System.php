<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\time\SystemTimeProvider;

class System {
	
	/**
	 *
	 * @return integer Returns the current time in milliseconds.
	 */
	static function currentTimeMillis() {
		$provider = new SystemTimeProvider();
		return $provider->currentTimeMillis ();
	}

	/**
	 *
	 * @return string
	 * @see http://php.net/sys_get_temp_dir
	 */
	static function getTemporaryDirectory() {
		return sys_get_temp_dir ();
	}

	/**
	 *
	 * @return array
	 * @see http://www.php.net/manual/en/function.sys-getloadavg.php
	 */
	static function getLoadAverage() {
		return sys_getloadavg ();
	}

	static function isCLI() {
		$sapi = php_sapi_name ();
		return ($sapi === 'cli'); // TODO: discourage string literals
	}

	static function isCGI() {
		$sapi = php_sapi_name ();
		return String::valueOf ( $sapi )->startsWith ( 'cgi' );
	}
	
	private function __construct() {
		
	}

}