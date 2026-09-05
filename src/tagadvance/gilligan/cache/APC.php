<?php

namespace tagadvance\gilligan\cache;

use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\text\ByteCountFormatter;
use tagadvance\gilligan\text\HumanReadableByteCountFormatter;
use tagadvance\gilligan\text\StringClass;

Extensions::getInstance()->requires('apcu');

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
 * Merely autoloading this file asserts that <code>apcu</code> is installed, so a host without
 * the extension fails at load time rather than at first use.
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 */
class APC implements Cache
{
    public const CACHE_TYPE = 'user';

    private $timeToLive;

    /**
     * @param int $timeToLive seconds each entry written through this instance should live;
     *        0, the default, means never expire
     */
    public function __construct(int $timeToLive = 0)
    {
        $this->timeToLive = $timeToLive;
    }

    public function __set($name, $value)
    {
        apcu_store($name, $value, $this->timeToLive);
    }

    /**
     * Yields false for a key that is absent, which a stored <code>false</code> is
     * indistinguishable from; use <code>isset()</code> to tell them apart.
     */
    public function __get($name)
    {
        return apcu_fetch($name);
    }

    public function __isset($name): bool
    {
        return apcu_exists($name);
    }

    public function __unset($name)
    {
        return apcu_delete($name);
    }

    /**
     * Empties the whole user cache for the process, not just the entries written through this
     * instance.
     */
    public function clear()
    {
        apcu_clear_cache();
    }

    /**
     * A var_export of every entry in the user cache, which on a warm cache is very large.
     *
     * @see apcu_cache_info
     */
    public function __toString(): string
    {
        return $this->toHumanReadableString();
    }

    /**
     * Walks the entire user cache, so treat it as a diagnostic rather than something to call
     * on a request path.
     *
     * @param string $format date() format applied to every field whose name ends in `time`
     *        (default is ISO 8601)
     * @param ByteCountFormatter|null $formatter formats every `mem_` field; null selects
     *        {@link HumanReadableByteCountFormatter}
     */
    public function toHumanReadableString($format = 'c', ?ByteCountFormatter $formatter = null): string
    {
        if ($formatter == null) {
            $formatter = new HumanReadableByteCountFormatter();
        }

        $user_info = apcu_cache_info($limited = false);
        if ($user_info !== false) {
            self::replaceFields($user_info, $format, $formatter);
            foreach ($user_info['cache_list'] as &$entry) {
                self::replaceFields($entry, $format, $formatter);
            }
        }

        return var_export($user_info, $return = true);
    }

    private static function replaceFields(array &$array, string $format, ByteCountFormatter $formatter)
    {
        foreach ($array as $name => &$value) {
            if (StringClass::valueOf($name)->endsWith('time')) {
                $value = date($format, $value);
            }
            if (StringClass::valueOf($name)->startsWith('mem_')) {
                $value = $formatter->format($value, $decimals = 2);
            }
        }
    }

}
