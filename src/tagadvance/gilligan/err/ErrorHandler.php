<?php

namespace tagadvance\gilligan\err;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface ErrorHandler {

    /**
     *
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     * @param int $errline
     * @param array $errcontext
     * @return boolean <code>true</code> to exit or <code>false</false> to
     *         continue
     * @see http://www.php.net/manual/en/function.set-exception-handler.php
     */
    function handleError($errno, $errstr, $errfile, $errline, $errcontext);

}