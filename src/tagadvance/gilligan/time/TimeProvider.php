<?php

namespace tagadvance\gilligan\time;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface TimeProvider {

	/**
	 * 
	 * @return int Returns the current time in milliseconds.
	 */
	function currentTimeMillis(): int;

}