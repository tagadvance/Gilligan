<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\traits\Singleton;

final class Globals {
    
    use Singleton;

    function __get($name) {
        return $GLOBALS[$name];
    }

    function __set($name, $value) {
        $GLOBALS[$name] = $value;
    }

    function __isset($name) {
        return isset($GLOBALS[$name]);
    }

    function __unset($name) {
        unset($GLOBALS[$name]);
    }

}