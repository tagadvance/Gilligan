<?php

namespace tagadvance\gilligan\err;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface UncaughtExceptionHandler {

    /**
     *
     * @param Exception $e
     * @see http://php.net/manual/en/function.set-error-handler.php
     */
    function handleException(\Exception $e);

}