<?php

namespace tagadvance\gilligan\err;

/**
 * Intercept uncaught exceptions and errors.
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 */
class Err {

    private function __construct() {}

    static function interceptErrors(ErrorHandler $handler) {
        set_error_handler([
                $handler,
                'handleError'
        ]);
    }

    static function interceptUncaughtExceptions(UncaughtExceptionHandler $handler) {
        set_exception_handler([
                $handler,
                'handleException'
        ]);
    }

}