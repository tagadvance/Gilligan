<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\io\PrintStream;
use tagadvance\gilligan\io\ResourceOutputStream;
use tagadvance\gilligan\io\ResourceInputStream;

/**
 * 
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
class Standard {
	
	static function in(): ResourceInputStream {
		static $stream = null;
		if ($stream === null) {
			$stream = new ResourceInputStream ( STDIN );
		}
		return $stream;
	}
	
	static function out(): PrintStream {
		static $stream = null;
		if ($stream === null) {
			$stream = new PrintStream ( new ResourceOutputStream(STDOUT) );
		}
		return $stream;
	}
	
	static function err(): PrintStream {
		static $stream = null;
		if ($stream === null) {
			$stream = new PrintStream ( new ResourceOutputStream(STDERR) );
		}
		return $stream;
	}
	
	static function output() {
		static $stream = null;
		if ($stream === null) {
			$stream = new PrintStream ( ResourceOutputStream::createDefaultOutputStream () );
		}
		return $stream;
	}
	
	private function __construct() {
	}
	
}