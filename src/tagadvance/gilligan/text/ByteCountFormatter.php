<?php

namespace tagadvance\gilligan\text;

/**
 *
 * @see http://stackoverflow.com/questions/3758606/how-to-convert-byte-size-into-human-readable-format-in-java
 */
interface ByteCountFormatter {

	function format(int $byteCount, int $decimals): string;

}