<?php

namespace tagadvance\gilligan\text;

use \NumberFormatter;

/**
 * @deprecated use {@link NumberFormatter} if available (requires PECL intl >= 1.0.0)
 */
class Ordinal {
    
	const TH = 'th', ST = 'st', ND = 'nd', RD = 'rd';
	
    private function __construct() {
        
    }
	
	/**
	 *
	 * @param int $n        	
	 * @return string
	 * @see http://stackoverflow.com/a/3110033
	 */
	static function getSuffix(int $n): string {
		$r = $n % 100;
		if ($r >= 11 && $r <= 13) {
			return self::TH;
		}
		$suffixes = [ 
				self::TH,
				self::ST,
				self::ND,
				self::RD 
		];
		$index = $n % 10;
		return $suffixes [$index] ?? self::TH;
	}
    
}