<?php

namespace tagadvance\gilligan\io;

interface Flushable {
	
	/**
	 * @throw IOException
	 */
	function flush();
	
}