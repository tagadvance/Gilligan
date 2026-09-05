<?php

namespace tagadvance\gilligan\time;

use tagadvance\gilligan\base\Extensions;

Extensions::getInstance()->requires('bcmath');

/**
 * The real clock, read from microtime() and truncated to whole milliseconds.
 * It is wall-clock time, so it can jump or run backwards when the system clock is adjusted.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class SystemTimeProvider implements TimeProvider
{
    public const MILLISECONDS_PER_SECOND = 1000;

    public function currentTimeMillis(): int
    {
        $microtime = microtime($get_as_float = true);
        return bcmul($microtime, self::MILLISECONDS_PER_SECOND, $scale = 0);
    }

}
