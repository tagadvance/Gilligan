<?php

namespace tagadvance\gilligan\collections;

use tagadvance\gilligan\security\Hash;
use tagadvance\gilligan\base\Hashable;

/**
 * This class allows one to use objects as array keys.
 * A key implementing {@link Hashable} is filed under its own hash code, any other object under
 * its identity, and a scalar under a hash of its serialization — so <code>1</code> and
 * <code>'1'</code> are distinct keys.
 *
 * @author Alex (bosmeeuw)
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see http://bosmeeuw.wordpress.com/2011/07/21/php-using-objects-as-keys-for-a-hash/
 * @license There is no copyright or license information provided on the
 *          website, so an attribution will have to suffice.
 */
class HashArray implements \ArrayAccess
{
    /**
     * @var array<string, mixed> key objects indexed by hash
     */
    private $keys = [];

    /**
     * @var array<string, mixed> values indexed by the hash of their key
     */
    private $values = [];

    public function __construct() {}

    /**
     * Warns and yields null for an absent key rather than throwing.
     */
    public function offsetGet(mixed $offset): mixed
    {
        $hash = self::createHash($offset);
        return $this->values[$hash];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $hash = self::createHash($offset);
        $this->keys[$hash] = $offset;
        $this->values[$hash] = $value;
    }

    public function offsetExists(mixed $offset): bool
    {
        $hash = self::createHash($offset);
        return isset($this->keys[$hash]);
    }

    public function offsetUnset(mixed $offset): void
    {
        $hash = self::createHash($offset);
        unset($this->keys[$hash], $this->values[$hash]);
    }

    /**
     * The key objects in insertion order, positionally aligned with {@link self::getValues()}.
     */
    public function getKeys()
    {
        return array_values($this->keys);
    }

    /**
     * The values in insertion order, positionally aligned with {@link self::getKeys()}.
     */
    public function getValues()
    {
        return array_values($this->values);
    }

    private static function createHash($value)
    {
        if ($value instanceof Hashable) {
            return $value->hashCode();
        } elseif (is_object($value)) {
            return spl_object_hash($value);
        } else {
            $serializedValue = serialize($value);
            return Hash::sha1($serializedValue);
        }
    }

}
