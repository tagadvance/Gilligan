<?php

namespace tagadvance\gilligan\io;

// TODO: fileinputstream
class FileOutputStream extends ResourceOutputStream {

	function __construct(File $file, $append = false) {
		$path = $file->getRealPath();
		$mode = $append ? FileMode::WRITE_ONLY_APPEND : FileMode::WRITE_ONLY_TRUNCATE;
		$handle = fopen ( $path, $mode );
		parent::__construct ( $handle );
	}

}