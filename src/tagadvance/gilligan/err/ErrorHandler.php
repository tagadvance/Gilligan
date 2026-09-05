<?php

namespace tagadvance\gilligan\err;

/**
 * Object form of a set_error_handler() callback, installed by {@link Err::interceptErrors()}.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface ErrorHandler
{
    /**
     * @param int $errno one of the <code>E_*</code> constants
     * @return bool <code>false</code> to fall through to PHP's own error handler; any other
     *         value, <code>null</code> included, suppresses it
     * @see http://www.php.net/manual/en/function.set-error-handler.php
     */
    public function handleError($errno, $errstr, $errfile, $errline);

}
