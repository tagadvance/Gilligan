<?php

namespace tagadvance\gilligan\io;

use tagadvance\gilligan\base\UnsupportedOperationException;

class PrintStream extends ResourceOutputStream {
	
	function __construct(OutputStream $delegatee) {
		parent::__construct ( $delegatee->handle );
	}
	
	/**
	 * 
	 * @param string $message
	 * @return int the number of bytes written  
	 */
	function printLine(string $message = ''): int {
		return $this->write ( $message . PHP_EOL );
	}
	
	/**
	 * Convenience method.
	 *
	 * @param string $format        	
	 * @param string $args,...
	 * @return the number of bytes written  
	 * @see http://www.php.net/manual/en/function.sprintf.php
	 */
	function printFormatted(string $format): int {
		$args = func_get_args ();
		$s = call_user_func_array ( 'sprintf', $args );
		return $this->write ( $s );
	}
	
	function __call($name, array $arguments) {
		// Avoid syntax error, unexpected 'print', expecting 'identifier'
		if ($name === 'print') {
			$callback = [ 
					$this,
					'write' 
			];
			return call_user_func_array ( $callback, $arguments );
		}
		
		throw new UnsupportedOperationException ( "$name" );
	}
	
}