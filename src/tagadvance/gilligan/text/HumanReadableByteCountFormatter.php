<?php

namespace tagadvance\gilligan\text;

/**
 * Binary scaling: 1024 to the step, with IEC prefixes — KiB, MiB, GiB.
 */
class HumanReadableByteCountFormatter implements ByteCountFormatter
{
    public const UNIT = 1024;
    public const PREFIXES = 'KMGTPE';

    public function __construct() {}

    /**
     * A count below one unit is rendered in plain bytes, where <code>$decimals</code> has no
     * effect.
     */
    public function format(int $byteCount, int $decimals = 2): string
    {
        if ($byteCount < static::UNIT) {
            return "{$byteCount} B";
        }
        $format = "%.{$decimals}f %sB";
        $exp = (int) (log($byteCount) / log(static::UNIT));
        $count = $byteCount / pow(static::UNIT, $exp);
        $pre = $this->prefix($exp - 1);
        return sprintf($format, $count, $pre);
    }

    /**
     * The scale prefix for a power of {@link self::UNIT}; override it to change the notation
     * without touching the arithmetic.
     *
     * @param int $index zero-based index into {@link self::PREFIXES}
     */
    protected function prefix(int $index): string
    {
        $pre = self::PREFIXES;
        return $pre[$index] . 'i';
    }

}
