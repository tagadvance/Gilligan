<?php

namespace tagadvance\gilligan\io;

interface Closeable {
	
	/**
	 * @throws IOException
	 */
	function close();
	
}