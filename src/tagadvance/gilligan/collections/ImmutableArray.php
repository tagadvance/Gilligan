<?php

namespace tagadvance\gilligan\collections;

use tagadvance\gilligan\base\UnsupportedOperationException;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class ImmutableArray implements \ArrayAccess {

    private $array;

    function __construct(array $array) {
        $this->array = $array;
    }

    function __get($name) {
        return $this->offsetGet($name);
    }

    function offsetGet($offset) {
        return $this->array[$offset];
    }

    function __set($name, $value) {
        $this->offsetSet($name, $value);
    }

    function offsetSet($offset, $value) {
        throw new UnsupportedOperationException('immutable');
    }

    function __isset($name) {
        return $this->offsetExists($name);
    }

    function offsetExists($offset) {
        return isset($this->array[$offset]);
    }

    function __unset($name) {
        $this->offsetUnset($name);
    }

    function offsetUnset($offset) {
        throw new UnsupportedOperationException('immutable');
    }

}