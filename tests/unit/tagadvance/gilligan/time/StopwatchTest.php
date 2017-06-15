<?php

namespace tagadvance\gilligan\time;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\time\Stopwatch;

class StopwatchTest extends TestCase {
	
	function testCreate() {
		$stopwatch = Stopwatch::create();
		$this->assertNotNull($stopwatch);
	}
	
	function testStopwatch() {
		$timeProvider = new MockTimeProvider ();
		$stopwatch = (new Stopwatch ( $timeProvider ))->start ();
		$elapsedTime = $stopwatch->elapsedTimeInSeconds ();
		$this->assertEquals ( $expected = '1.00', $actual = $elapsedTime );
	}
	
}

class MockTimeProvider implements TimeProvider {
	
	private $times = [ 
			0,
			1000,
			2500
	];
	
	function currentTimeMillis(): int {
		return array_shift ( $this->times );
	}
	
}