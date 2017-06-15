<?php

namespace tagadvance\gilligan\io;

class MemoryOutputStream extends ResourceOutputStream {

	function __construct() {
		$handle = fopen ( 'php://memory', 'w+b' );
		parent::__construct ( $handle );
	}

	/**
	 * Reads remainder of a stream into a string
	 *
	 * @param integer $maxLength
	 *        	The maximum bytes to read. Defaults to -1 (read all the
	 *        	remaining buffer).
	 * @param integer $offset
	 *        	Seek to the specified offset before reading. If this number is
	 *        	negative, no seeking will occur and reading will start from
	 *        	the current position.
	 * @return string
	 * @throws IOException
	 * @see http://php.net/manual/en/function.stream-get-contents.php
	 */
	function getContents(int $maxLength = -1, int $offset = 0) {
		$contents = stream_get_contents ( $this->handle, $maxLength, $offset );
		if ($contents === false) {
			throw new IOException ( __METHOD__ . ' failed' );
		}
		return $contents;
	}

}