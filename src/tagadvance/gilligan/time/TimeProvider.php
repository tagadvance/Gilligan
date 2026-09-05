<?php

namespace tagadvance\gilligan\time;

/**
 * A clock as an injectable collaborator, so timing code can be driven from a test.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface TimeProvider
{
    /**
     *
     * @return int Returns the current time in milliseconds.
     */
    public function currentTimeMillis(): int;

}
