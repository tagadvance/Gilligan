<?php

namespace tagadvance\gilligan\io;

class ResourceInputStream implements InputStream {

	protected $handle;

	function __construct(/* resource */ $handle) {
		if (! is_resource ( $handle )) {
			$message = '$handle must be a resource';
			throw new \InvalidArgumentException ( $message );
		}
		
		$this->handle = $handle;
	}

	function read(int $length): string {
		$read = fread ( $this->handle, $length );
		if ($read === false && feof ( $handle ) === false) {
			throw new IOException ();
		}
		return $read;
	}
	
	function seek(int $offset) {
		$seek = fseek($this->handle, $offset);
		if ($seek === -1) {
			throw new IOException ();
		}
	}

	function skip(int $offset) {
		$seek = fseek($this->handle, $offset, SEEK_CUR);
		if ($seek === -1) {
			throw new IOException ();
		}
	}

	function rewind() {
		$isReset = rewind ( $this->handle );
		if (! $isReset) {
			throw new IOException ( __METHOD__ . ' failed' );
		}
	}

	function close() {
		$isClosed = fclose ( $this->handle );
		if (! $isClosed) {
			throw new IOException ();
		}
	}

}