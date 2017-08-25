<?php

namespace tagadvance\gilligan\collections;

use tagadvance\gilligan\security\Hash;
use tagadvance\gilligan\base\Hashable;

/**
 * This class allows one to use objects as array keys.
 *
 * @author Alex (bosmeeuw)
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see http://bosmeeuw.wordpress.com/2011/07/21/php-using-objects-as-keys-for-a-hash/
 * @license There is no copyright or license information provided on the
 *          website, so an attribution will have to suffice.
 */
class HashArray implements \ArrayAccess {

    /**
     *
     * @var array
     */
    private $keys = [];

    /**
     *
     * @var array
     */
    private $values = [];

    function __construct() {}

    function offsetGet($offset) {
        $hash = self::createHash($offset);
        return $this->values[$hash];
    }

    function offsetSet($offset, $value) {
        $hash = self::createHash($offset);
        $this->keys[$hash] = $offset;
        $this->values[$hash] = $value;
    }

    function offsetExists($offset) {
        $hash = self::createHash($offset);
        return isset($this->keys[$hash]);
    }

    function offsetUnset($offset) {
        $hash = self::createHash($offset);
        unset($this->keys[$hash], $this->values[$hash]);
    }

    function getKeys() {
        return array_values($this->keys);
    }

    function getValues() {
        return array_values($this->values);
    }

    private static function createHash($value) {
        if ($value instanceof Hashable) {
            return $value->hashCode();
        } else if (is_object($value)) {
            return spl_object_hash($value);
        } else {
            $serializedValue = serialize($value);
            return Hash::sha1($serializedValue);
        }
    }

}