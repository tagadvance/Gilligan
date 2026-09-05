<?php

namespace tagadvance\gilligan\text;

/**
 * Renders a byte count for a human to read.
 *
 * @see http://stackoverflow.com/questions/3758606/how-to-convert-byte-size-into-human-readable-format-in-java
 */
interface ByteCountFormatter
{
    /**
     * @param int $decimals digits after the point in the scaled figure
     * @return string the count scaled and suffixed with its unit, e.g. '1.50 KiB'
     */
    public function format(int $byteCount, int $decimals): string;

}
