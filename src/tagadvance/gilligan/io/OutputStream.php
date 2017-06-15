<?php

namespace tagadvance\gilligan\io;

interface OutputStream extends Flushable, Closeable {
	
	/**
	 *
	 * @param string $string The string that is to be written.
	 * @param int $length If the length argument is given, writing will stop after length bytes have been written or the end of string is reached, whichever comes first.
	 * @return integer returns the number of bytes written
	 * @throws IOException
	 * @see http://php.net/manual/en/function.fwrite.php
	 */
	function write(string $string, int $length = null): int;

}