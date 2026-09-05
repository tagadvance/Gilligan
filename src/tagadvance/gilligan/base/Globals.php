<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\traits\Singleton;

/**
 * An object facade over <code>$GLOBALS</code>.
 * It is a live view rather than a copy, so a write here is visible to every other reader of
 * the global scope.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
final class Globals
{
    use Singleton;

    /**
     * Warns and yields null for a name that is not set; test with <code>isset()</code> first.
     */
    public function __get($name)
    {
        return $GLOBALS[$name];
    }

    public function __set($name, $value)
    {
        $GLOBALS[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($GLOBALS[$name]);
    }

    public function __unset($name)
    {
        unset($GLOBALS[$name]);
    }

}
