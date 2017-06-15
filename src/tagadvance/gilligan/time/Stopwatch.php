<?php

namespace tagadvance\gilligan\time;

use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\time\SystemTimeProvider;

Extensions::getInstance ()->requires ( 'bcmath' );

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class Stopwatch {
	
	/**
	 * 
	 * @var TimeProvider
	 */
	private $timeProvider;
	/**
	 * 
	 * @var int
	 */
	private $start;
	
	function __construct(TimeProvider $timeProvider) {
		$this->timeProvider = $timeProvider;
		$this->start = - 1;
	}
	
	/**
	 * Start the stopwatch.
	 * @return self
	 */
	function start(): self {
		$this->start = $this->timeProvider->currentTimeMillis ();
		return $this;
	}
	
	function elapsedTimeInSeconds($decimals = 2): string {
		if ($this->start < 0) {
			throw new \BadMethodCallException ( 'start the stopwatch first!' );
		}
		
		$stop = $this->timeProvider->currentTimeMillis ();
		$millisElapsed = $stop - $this->start;
		$secondsElapsed = bcdiv ( $millisElapsed, SystemTimeProvider::MILLISECONDS_PER_SECOND, $decimals );
		return $secondsElapsed;
	}
	
	function stopAndReset() {
		$this->start = - 1;
	}
	
	static final function create() {
		$timeProvider = new SystemTimeProvider ();
		return new self ( $timeProvider );
	}
	
}