<?php

namespace tagadvance\gilligan\collections;

use tagadvance\gilligan\base\UnsupportedOperationException;

/**
 * A read-only view of an array, reachable by either array or property syntax.
 * Immutability is shallow: the array itself cannot be altered through this object, but any
 * object stored in it remains mutable.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class ImmutableArray implements \ArrayAccess
{
    private $array;

    /**
     * @param array $array copied by value, so later changes to the caller's array are not seen
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * Warns and yields null for an absent offset rather than throwing.
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset];
    }

    /**
     * @throws UnsupportedOperationException always
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @throws UnsupportedOperationException always
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        throw new UnsupportedOperationException('immutable');
    }

    public function __isset($name)
    {
        return $this->offsetExists($name);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->array[$offset]);
    }

    /**
     * @throws UnsupportedOperationException always
     */
    public function __unset($name)
    {
        $this->offsetUnset($name);
    }

    /**
     * @throws UnsupportedOperationException always
     */
    public function offsetUnset(mixed $offset): void
    {
        throw new UnsupportedOperationException('immutable');
    }

}
