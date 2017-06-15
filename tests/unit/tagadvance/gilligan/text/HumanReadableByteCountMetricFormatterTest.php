<?php

namespace tagadvance\gilligan\text;

use PHPUnit\Framework\TestCase;

class HumanReadableByteCountMetricFormatterTest extends TestCase {
	
	function testFormat() {
		$formatter = new HumanReadableByteCountMetricFormatter ();
		$count = 18578324;
		$formattedCount = $formatter->format ( $count );
		$this->assertEquals ( $expected = '18.58 MB', $actual = $formattedCount );
	}
	
}