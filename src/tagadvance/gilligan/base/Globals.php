<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\traits\Singleton;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
final class Globals
{
    use Singleton;

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
