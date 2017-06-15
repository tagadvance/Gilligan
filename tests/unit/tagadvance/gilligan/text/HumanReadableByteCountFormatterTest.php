<?php

namespace tagadvance\gilligan\text;

use PHPUnit\Framework\TestCase;

class HumanReadableByteCountFormatterTest extends TestCase {
	
	function testFormat() {
		$formatter = new HumanReadableByteCountFormatter ();
		$count = 18578324;
		$formattedCount = $formatter->format ( $count );
		$this->assertEquals ( $expected = '17.72 MiB', $actual = $formattedCount );
	}
	
}