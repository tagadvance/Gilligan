<?php

namespace tagadvance\gilligan\io;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
final class Closer {
	
	private function __consruct() {
	}
	
	static function close(Closeable $closeable = null) {
		if ($closeable !== null) {
			$closeable->close ();
		}
	}
	
	static function closeQuietly(Closeable $closeable = null) {
		if ($closeable !== null) {
			try {
				$closeable->close ();
			} catch ( IOException $e ) {
				// eat it
			}
		}
	}
	
}