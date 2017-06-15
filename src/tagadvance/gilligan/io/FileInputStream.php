<?php

namespace tagadvance\gilligan\io;

class FileInputStream extends ResourceInputStream {

	function __construct(File $file) {
		$path = $file->getRealPath();
		$handle = fopen ( $path, FileMode::READ_ONLY );
		parent::__construct ( $handle );
	}

}