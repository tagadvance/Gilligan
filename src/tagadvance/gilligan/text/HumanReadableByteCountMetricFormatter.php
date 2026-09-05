<?php

namespace tagadvance\gilligan\text;

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
