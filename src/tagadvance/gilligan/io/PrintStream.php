<?php

namespace tagadvance\gilligan\io;

use tagadvance\gilligan\base\UnsupportedOperationException;

/**
 * Adds line and format conveniences to an existing stream.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class PrintStream extends ResourceOutputStream
{
    /**
     * Shares the delegate's handle rather than wrapping it, so closing either one closes both.
     */
    public function __construct(ResourceOutputStream $delegatee)
    {
        parent::__construct($delegatee->handle);
    }

    /**
     * @return int the number of bytes written, PHP_EOL included
     */
    public function printLine(string $message = ''): int
    {
        return $this->write($message . PHP_EOL);
    }

    /**
     * Takes sprintf() arguments after <code>$format</code> through func_get_args(), so they do
     * not appear in the signature and named arguments will not reach them.
     *
     * @return int the number of bytes written
     * @see http://www.php.net/manual/en/function.sprintf.php
     */
    public function printFormatted(string $format): int
    {
        $args = func_get_args();
        $s = call_user_func_array('sprintf', $args);
        return $this->write($s);
    }

    /**
     * Serves <code>print()</code> as an alias of {@link self::write()}, which cannot be
     * declared outright because <code>print</code> is a reserved word.
     *
     * @throws UnsupportedOperationException for any other name
     */
    public function __call($name, array $arguments)
    {
        // Avoid syntax error, unexpected 'print', expecting 'identifier'
        if ($name === 'print') {
            $callback = [
                $this,
                'write',
            ];
            return call_user_func_array($callback, $arguments);
        }

        throw new UnsupportedOperationException("$name");
    }

}
