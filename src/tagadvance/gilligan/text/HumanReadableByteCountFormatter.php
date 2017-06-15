<?php

namespace tagadvance\gilligan\text;

class HumanReadableByteCountFormatter implements ByteCountFormatter {
	
	const UNIT = 1024;
	const PREFIXES = 'KMGTPE';
	
	function __construct() {
	}
	
	function format(int $byteCount, int $decimals = 2): string {
		if ($byteCount < static::UNIT) {
			return "{$byteCount} B";
		}
		$format = "%.{$decimals}f %sB";
		$exp = ( int ) (log ( $byteCount ) / log ( static::UNIT ));
		$count = $byteCount / pow ( static::UNIT, $exp );
		$pre = $this->prefix ( $exp - 1 );
		return sprintf ( $format, $count, $pre );
	}
	
	protected function prefix(int $index): string {
		$pre = self::PREFIXES;
		return $pre {$index} . 'i';
	}
	
}