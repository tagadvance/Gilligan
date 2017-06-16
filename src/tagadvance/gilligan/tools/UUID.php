<?php

namespace tagadvance\gilligan\tools;

/**
 * Licensed under Attribution 3.0 Unported.
 * 
 * Original author is Andrew Moore.
 * 
 * The following class generates VALID RFC 4211 COMPLIANT Universally Unique IDentifiers (UUID) version 3, 4 and 5.
 *
 * Version 3 and 5 UUIDs are named based. They require a namespace (another valid UUID) and a value (the name). Given the same namespace and name, the output is always the same.
 *
 * Version 4 UUIDs are pseudo-random.
 *
 * UUIDs generated below validates using OSSP UUID Tool, and output for named-based UUIDs are exactly the same. This is a pure PHP implementation.
 *
 * @see https://creativecommons.org/licenses/by/3.0/
 * @see http://php.net/manual/en/function.uniqid.php#94959
 */
class UUID {	
	
	static function v3(string $namespace, string $name) {
		if (! self::is_valid ( $namespace ))
			return false;
		
		// Get hexadecimal components of namespace
		$search = [ '-', '{', '}' ];
		$nhex = str_replace ( $search, $replace = '', $namespace );
		
		// Binary Value
		$nstr = '';
		
		// Convert Namespace UUID to bits
		for ($i = 0; $i < strlen ( $nhex ); $i += 2) {
			$nstr .= chr ( hexdec ( $nhex [$i] . $nhex [$i + 1] ) );
		}
		
		// Calculate hash value
		$hash = md5 ( $nstr . $name );
		
		// 32 bits for "time_low"
		$time_low = substr ( $hash, 0, 8 );
		
		// 16 bits for "time_mid"
		$time_mid = substr ( $hash, 8, 4 );
		
		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 3
		$time_hi_and_version = (hexdec ( substr ( $hash, 12, 4 ) ) & 0x0fff) | 0x3000;
		
		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		$clk_seq_hi_res = (hexdec ( substr ( $hash, 16, 4 ) ) & 0x3fff) | 0x8000;
		
		// 48 bits for "node"
		$node = substr ( $hash, 20, 12 );
		
		return sprintf ( '%08s-%04s-%04x-%04x-%12s', $time_low, $time_mid, $time_hi_and_version, $clk_seq_hi_res, $node );
	}
	
	static function v4() {
		// 32 bits for "time_low"
		$time_low1 = mt_rand ( 0, 0xffff );
		$time_low2 = mt_rand ( 0, 0xffff );
		
		// 16 bits for "time_mid"
		$time_mid = mt_rand ( 0, 0xffff );
		
		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 4
		$time_hi_and_version = mt_rand ( 0, 0x0fff ) | 0x4000;
		
		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		$clk_seq_hi_res = mt_rand ( 0, 0x3fff ) | 0x8000;
		
		// 48 bits for "node"
		$node1 = mt_rand ( 0, 0xffff );
		$node2 = mt_rand ( 0, 0xffff );
		$node3 = mt_rand ( 0, 0xffff );
		
		return sprintf ( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x', $time_low1, $time_low2, $time_mid, $time_hi_and_version, $clk_seq_hi_res, $node1, $node2, $node3 );
	}
	
	static function v5(string $namespace, string $name) {
		if (! self::is_valid ( $namespace ))
			return false;
		
		// Get hexadecimal components of namespace
		$search = [ '-', '{', '}' ];
		$nhex = str_replace ( $search, $replace = '', $namespace );
		
		// Binary Value
		$nstr = '';
		// Convert Namespace UUID to bits
		for ($i = 0; $i < strlen ( $nhex ); $i += 2) {
			$nstr .= chr ( hexdec ( $nhex [$i] . $nhex [$i + 1] ) );
		}
		
		$hash = sha1 ( $nstr . $name );
		
		// 32 bits for "time_low"
		$time_low = substr ( $hash, 0, 8 );
		
		// 16 bits for "time_mid"
		$time_mid = substr ( $hash, 8, 4 );
		
		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 5
		$time_hi_and_version = (hexdec ( substr ( $hash, 12, 4 ) ) & 0x0fff) | 0x5000;
		
		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		$clk_seq_hi_res = (hexdec ( substr ( $hash, 16, 4 ) ) & 0x3fff) | 0x8000;
		
		// 48 bits for "node"
		$node = substr ( $hash, 20, 12 );
		
		return sprintf ( '%08s-%04s-%04x-%04x-%12s', $time_low, $time_mid, $time_hi_and_version, $clk_seq_hi_res, $node );
	}
	
	static function is_valid($uuid) {
		$pattern = '/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i';
		return preg_match ( $pattern, $uuid ) === 1;
	}
	
	private function __construct() {
		
	}
	
}