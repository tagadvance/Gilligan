<?php

namespace tagadvance\gilligan\text;

/**
 * Decimal scaling: 1000 to the step, with SI prefixes — kB, MB, GB — as disk vendors count.
 */
class HumanReadableByteCountMetricFormatter extends HumanReadableByteCountFormatter
{
    public const UNIT = 1000;

    public const PREFIXES = 'kMGTPE';

    protected function prefix(int $index): string
    {
        $pre = self::PREFIXES;
        return $pre[$index];
    }

}
