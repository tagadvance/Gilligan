<?php

namespace tagadvance\gilligan\text;

/**
 * The English ordinal suffix for a number: 1st, 2nd, 3rd, 4th.
 *
 * @deprecated use {@link NumberFormatter} if available (requires PECL intl >= 1.0.0)
 */
class Ordinal
{
    public const TH = 'th';
    public const ST = 'st';
    public const ND = 'nd';
    public const RD = 'rd';

    private function __construct() {}

    /**
     * @return string one of {@link self::TH}, {@link self::ST}, {@link self::ND} or
     *         {@link self::RD}; a negative $n always yields 'th', since the modulo goes negative
     * @see http://stackoverflow.com/a/3110033
     */
    public static function getSuffix(int $n): string
    {
        $r = $n % 100;
        if ($r >= 11 && $r <= 13) {
            return self::TH;
        }
        $suffixes = [
            self::TH,
            self::ST,
            self::ND,
            self::RD,
        ];
        $index = $n % 10;
        return $suffixes[$index] ?? self::TH;
    }

}
