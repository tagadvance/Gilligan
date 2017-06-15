<?php

namespace tagadvance\gilligan\io;

class ResourceOutputStream implements OutputStream {

	protected $handle;
	
	static function createDefaultOutputStream() {
		$handle = fopen ( 'php://output', FileMode::WRITE_ONLY_APPEND );
		return new self ( $handle );
	}
	
	/**
	 *
	 * @param resource $handle        	
	 */
	function __construct(/* resource */ $handle) {
		if (! is_resource ( $handle )) {
			$message = '$handle must be a resource';
			throw new \InvalidArgumentException ( $message );
		}
		$this->handle = $handle;
	}
	
	function write(string $string, int $length = null): int {
		if ($length === null) {
			$byteCount = fwrite ( $this->handle, $string );
		} else {
			$byteCount = fwrite ( $this->handle, $string, $length );
		}
		if ($byteCount === false) {
			throw new IOException ();
		}
		return $byteCount;
	}

	function flush() {
		$isFlushed = fflush ( $this->handle );
		if (! $isFlushed) {
			throw new IOException ();
		}
	}

	function close() {
		$isClosed = fclose ( $this->handle );
		if (! $isClosed) {
			throw new IOException ();
		}
	}

}