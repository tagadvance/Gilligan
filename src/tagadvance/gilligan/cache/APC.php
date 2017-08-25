<?php

namespace tagadvance\gilligan\cache;

use tagadvance\gilligan\base\Extensions, tagadvance\gilligan\text\ByteCountFormatter, tagadvance\gilligan\text\HumanReadableByteCountFormatter;
use tagadvance\gilligan\text\StringClass;

Extensions::getInstance()->requires('apc');

/**
 *
 * This is class designed to make APC access more convenient, e.g.
 * <code>
 * $apc = new Apc();
 * $apc->foo = 'bar';
 * $apc->key = 'value';
 * $apc->key;
 * $apc->key;
 * $apc->gone = 'with the wind';
 * unset($apc->gone);
 * print $apc->__toString();
 * </code>
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 */
class APC implements Cache {

    const CACHE_TYPE = 'user';

    function __construct() {}

    function __set($name, $value) {
        apc_store($name, $value);
    }

    function __get($name) {
        return apc_fetch($name);
    }

    function __isset($name): bool {
        return apc_exists($name);
    }

    function __unset($name) {
        return apc_delete($name);
    }

    function clear() {
        apc_clear_cache(self::CACHE_TYPE);
    }

    /**
     *
     * @return string
     * @see apc_cache_info
     */
    function __toString(): string {
        return $this->toHumanReadableString();
    }

    /**
     *
     * @param string $format
     *            (default is ISO 8601)
     * @param ByteCountFormatter $formatter
     * @return mixed
     */
    function toHumanReadableString($format = 'c', ByteCountFormatter $formatter = null): string {
        if ($formatter == null) {
            $formatter = new HumanReadableByteCountFormatter();
        }
        
        $user_info = apc_cache_info(self::CACHE_TYPE);
        if ($user_info !== false) {
            self::replaceFields($user_info, $format, $formatter);
            foreach ($user_info['cache_list'] as &$entry) {
                self::replaceFields($entry, $format, $formatter);
            }
        }
        
        return var_export($user_info, $return = true);
    }

    private static function replaceFields(array &$array, string $format, ByteCountFormatter $formatter) {
        foreach ($array as $name => &$value) {
            if (StringClass::valueOf($name)->endsWith('time')) {
                $value = date($format, $value);
            }
            if (StringClass::valueOf($name)->startsWith('mem_')) {
                $value = $formatter->format($value);
            }
        }
    }

}