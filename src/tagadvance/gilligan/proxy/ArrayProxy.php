<?php

namespace tagadvance\gilligan\proxy;

/**
 * This class is useful for exposing an array as an object without duplicating information, e.g.
 * by casting to object.
 * The array is held by reference, so every write through the proxy lands in the caller's own
 * array.
 *
 * @author Tag
 *
 */
class ArrayProxy implements \ArrayAccess, \Serializable
{
    private $array;

    /**
     * @param array $array taken by reference and not copied, so the proxy and the caller share
     *        one array for the life of the object
     */
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

    /**
     * Warns and yields null for a key that is not present.
     */
    public function __get($name)
    {
        return $this->array[$name];
    }

    /**
     * Warns and yields null for a key that is not present.
     */
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

    /**
     * Part of the deprecated \Serializable interface, which this class still declares alongside
     * __serialize()/__unserialize(); PHP prefers the latter pair, so this is dead weight.
     */
    public function serialize()
    {
        return serialize($this->array);
    }

    /**
     * Part of the deprecated \Serializable interface; see {@link self::serialize()}.
     */
    public function unserialize($data)
    {
        $this->array = unserialize($data);
    }

}
