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

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->array[$offset] = $value;
    }

    public function __get($name)
    {
        return $this->array[$name];
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset];
    }

    public function __isset($name)
    {
        return isset($this->array[$name]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function __unset($name)
    {
        unset($this->array[$name]);
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->array[$offset]);
    }

    public function __serialize(): array
    {
        return [$this->array];
    }

    public function __unserialize(array $data): void
    {
        $this->array = $data[0];
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
