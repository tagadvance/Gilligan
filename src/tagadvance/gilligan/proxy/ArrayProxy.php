<?php

namespace tagadvance\gilligan\proxy;

/**
 * This class is useful for exposing an array as an object without duplicating information, e.g.
 * by casting to object.
 *
 * @author Tag
 *        
 */
class ArrayProxy implements \ArrayAccess, \Serializable {

    private $array;

    function __construct(array &$array) {
        $this->array = &$array;
    }

    function __set($name, $value) {
        $this->array[$name] = $value;
    }

    function offsetSet($offset, $value) {
        $this->array[$offset] = $value;
    }

    function __get($name) {
        return $this->array[$name];
    }

    function offsetGet($offset) {
        return $this->array[$offset];
    }

    function __isset($name) {
        return isset($this->array[$name]);
    }

    function offsetExists($offset) {
        return isset($this->array[$offset]);
    }

    function __unset($name) {
        unset($this->array[$name]);
    }

    function offsetUnset($offset) {
        unset($this->array[$offset]);
    }

    function serialize() {
        return serialize($this->array);
    }

    function unserialize($data) {
        $this->array = unserialize($data);
    }

}