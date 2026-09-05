<?php

namespace tagadvance\gilligan\time;

use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\time\SystemTimeProvider;

Extensions::getInstance()->requires('bcmath');

/**
 * Measures elapsed time against an injectable clock.
 * Because that clock is wall-clock time, a system clock adjustment mid-measurement shows up in
 * the result.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class Stopwatch
{
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

    public function __construct(TimeProvider $timeProvider)
    {
        $this->timeProvider = $timeProvider;
        $this->start = - 1;
    }

    /**
     * Start the stopwatch, discarding any measurement already in progress.
     *
     * @return self this, for chaining
     */
    public function start(): self
    {
        $this->start = $this->timeProvider->currentTimeMillis();
        return $this;
    }

    /**
     * Reads the elapsed time without stopping the clock, so successive calls keep growing.
     *
     * @param int $decimals digits after the point; bcmath truncates rather than rounds, so
     *        1.999s at 2 decimals reads 1.99
     * @throws \BadMethodCallException when {@link self::start()} has not been called since the
     *         last reset
     */
    public function elapsedTimeInSeconds($decimals = 2): string
    {
        if ($this->start < 0) {
            throw new \BadMethodCallException('start the stopwatch first!');
        }

        $stop = $this->timeProvider->currentTimeMillis();
        $millisElapsed = $stop - $this->start;
        $secondsElapsed = bcdiv($millisElapsed, SystemTimeProvider::MILLISECONDS_PER_SECOND, $decimals);
        return $secondsElapsed;
    }

    /**
     * Discards the measurement; {@link self::elapsedTimeInSeconds()} throws again until
     * {@link self::start()} is called.
     */
    public function stopAndReset()
    {
        $this->start = - 1;
    }

    /**
     * A stopwatch on the real clock, not yet started.
     * It builds with <code>new self()</code>, so a subclass calling this gets a plain Stopwatch.
     */
    final public static function create()
    {
        $timeProvider = new SystemTimeProvider();
        return new self($timeProvider);
    }

}
