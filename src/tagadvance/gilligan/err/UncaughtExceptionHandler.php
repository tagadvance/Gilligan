<?php

namespace tagadvance\gilligan\err;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface UncaughtExceptionHandler
{
    /**
     *
     * @param \Throwable $e
     * @see http://php.net/manual/en/function.set-exception-handler.php
     */
    public function handleException(\Throwable $e);

}
