<?php

namespace tagadvance\gilligan\err;

/**
 * Intercept uncaught exceptions and errors.
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 */
class Err
{
    private function __construct() {}

    /**
     * Replaces whatever error handler is installed, discarding it, so the previous one cannot
     * be restored.
     * Fatal levels such as <code>E_ERROR</code> and <code>E_PARSE</code> are never delivered
     * to a userland handler.
     */
    public static function interceptErrors(ErrorHandler $handler)
    {
        set_error_handler([
            $handler,
            'handleError',
        ]);
    }

    /**
     * Replaces whatever exception handler is installed, discarding it, so the previous one
     * cannot be restored.
     */
    public static function interceptUncaughtExceptions(UncaughtExceptionHandler $handler)
    {
        set_exception_handler([
            $handler,
            'handleException',
        ]);
    }

}
