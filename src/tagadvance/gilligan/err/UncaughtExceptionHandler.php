<?php

namespace tagadvance\gilligan\err;

/**
 * Object form of a set_exception_handler() callback, installed by
 * {@link Err::interceptUncaughtExceptions()}.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface UncaughtExceptionHandler
{
    /**
     * Called as the script's last act — PHP terminates once this returns.
     *
     * @see http://php.net/manual/en/function.set-exception-handler.php
     */
    public function handleException(\Throwable $e);

}
