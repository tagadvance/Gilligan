<?php

namespace tagadvance\gilligan\proxy;

/**
 * This class is useful for exposing an array as an object without duplicating information, e.g.
 * by casting to object.
 *
 * @author Tag
 *
 */
class ArrayProxy implements \ArrayAccess, \Serializable
{
    private $array;

    public function __construct(array &$array)
    {
        $this->array = &$array;
    }

    public function __set($name, $value)
    {
        $this->array[$name] = $value;
    }

    public function offsetSet($offset, $value)
    {
        $this->array[$offset] = $value;
    }

    public function __get($name)
    {
        return $this->array[$name];
    }

    public function offsetGet($offset)
    {
        return $this->array[$offset];
    }

    public function __isset($name)
    {
        return isset($this->array[$name]);
    }

    public function offsetExists($offset)
    {
        return isset($this->array[$offset]);
    }

    public function __unset($name)
    {
        unset($this->array[$name]);
    }

    public function offsetUnset($offset)
    {
        unset($this->array[$offset]);
    }

    public function serialize()
    {
        return serialize($this->array);
    }

    public function unserialize($data)
    {
        $this->array = unserialize($data);
    }

}
