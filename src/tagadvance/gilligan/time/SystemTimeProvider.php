<?php

namespace tagadvance\gilligan\time;

use tagadvance\gilligan\base\Extensions;

Extensions::getInstance ()->requires ( 'bcmath' );

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class SystemTimeProvider implements TimeProvider {

	const MILLISECONDS_PER_SECOND = 1000;
	
	function currentTimeMillis(): int {
		$microtime = microtime ( $get_as_float = true );
		return bcmul ( $microtime, self::MILLISECONDS_PER_SECOND, $scale = 0 );
	}

}