<?php

namespace tagadvance\gilligan\collections;

use tagadvance\gilligan\base\UnsupportedOperationException;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class ImmutableArray implements \ArrayAccess
{
    private $array;

    public function __construct(array $array)
    {
        $this->array = $array;
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset];
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

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

    public function __unset($name)
    {
        $this->offsetUnset($name);
    }

    public function offsetUnset(mixed $offset): void
    {
        throw new UnsupportedOperationException('immutable');
    }

}
