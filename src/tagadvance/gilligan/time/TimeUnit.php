<?php

namespace tagadvance\gilligan\util;

use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\traits\Singleton;

Extensions::getInstance()->requires('bcmath');

/**
 * Java class was written by Doug Lea with assistance from members of JCP
 * JSR-166 Expert Group and released to the public domain, as explained at
 * http://creativecommons.org/publicdomain/zero/1.0/ Other contributors include
 * Andrew Wright, Jeffrey Hayes, Pat Fisher, Mike Judd.
 *
 * A <tt>TimeUnit</tt> represents time durations at a given unit of
 * granularity and provides utility methods to convert across units,
 * and to perform timing and delay operations in these units.
 *
 * A <tt>TimeUnit</tt> does not maintain time information, but only
 * helps organize and use time representations that may be maintained
 * separately across various contexts. A nanosecond is defined as one
 * thousandth of a microsecond, a microsecond as one thousandth of a
 * millisecond, a millisecond as one thousandth of a second, a minute
 * as sixty seconds, an hour as sixty minutes, and a day as twenty four
 * hours.
 *
 * @see http://docs.oracle.com/javase/7/docs/api/java/util/concurrent/TimeUnit.html
 * @license <a href="http://creativecommons.org/publicdomain/zero/1.0/">Public Domain</a>
 */
abstract class TimeUnit {

    // Handy constants for conversion methods
    const NANOSECOND = 1;

    // nanosecond
    const NANOSECOND_PER_MICROSECOND = 1000;

    // NANOSECOND * 1000; microsecond
    const NANOSECOND_PER_MILLISECOND = 1000000;

    // NANOSECOND_PER_MICROSECOND * 1000; millisecond
    const NANOSECOND_PER_SECOND = 1000000000;

    // NANOSECOND_PER_MILLISECOND * 1000; second
    const NANOSECOND_PER_MINUTE = 60000000000;

    // NANOSECOND_PER_SECOND * 60; minute
    const NANOSECOND_PER_HOUR = 3600000000000;

    // NANOSECOND_PER_MINUTE * 60; hour
    const NANOSECOND_PER_DAY = 86400000000000;

    // NANOSECOND_PER_HOUR * 24; day
    static function NANOSECONDS(): NANOSECONDS {
        return NANOSECONDS::getInstance();
    }

    static function MICROSECONDS(): MICROSECONDS {
        return MICROSECONDS::getInstance();
    }

    static function MILLISECONDS(): MILLISECONDS {
        return MILLISECONDS::getInstance();
    }

    static function SECONDS(): SECONDS {
        return SECONDS::getInstance();
    }

    static function MINUTES(): MINUTES {
        return MINUTES::getInstance();
    }

    static function HOURS(): HOURS {
        return HOURS::getInstance();
    }

    static function DAYS(): DAYS {
        return DAYS::getInstance();
    }

    /**
     * Convert the given time duration in the given unit to this
     * unit.
     * Conversions from finer to coarser granularities
     * truncate, so lose precision. For example converting
     * <tt>999</tt> milliseconds to seconds results in
     * <tt>0</tt>.
     *
     * <p>For example, to convert 10 minutes to milliseconds, use:
     * <tt>TimeUnit::MILLISECONDS()->convert(10, TimeUnit::MINUTES())</tt>
     *
     * @param integer $sourceDuration
     *            the time duration in the given <tt>sourceUnit</tt>
     * @param TimeUnit $sourceUnit
     *            the unit of the <tt>sourceDuration</tt> argument
     * @return integer the converted duration in this unit
     */
    abstract function convert($sourceDuration, TimeUnit $sourceUnit): int;

    /**
     * Equivalent to <tt>NANOSECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            integer the duration
     * @return integer the converted duration.
     */
    abstract function toNanos(int $duration): int;

    /**
     * Equivalent to <tt>MICROSECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMicros(int $duration): int;

    /**
     * Equivalent to <tt>MILLISECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMillis(int $duration): int;

    /**
     * Equivalent to <tt>SECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toSeconds(int $duration): int;

    /**
     * Equivalent to <tt>MINUTES()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMinutes(int $duration): int;

    /**
     * Equivalent to <tt>HOURS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toHours(int $duration): int;

    /**
     * Equivalent to <tt>DAYS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration
     */
    abstract function toDays(int $duration): int;

    /**
     * Utility to compute the excess-nanosecond argument to sleep.
     *
     * @param integer $d
     *            the duration
     * @param integer $m
     *            the number of milliseconds
     * @return integer the number of nanoseconds
     */
    abstract function excessNanos($duration, $milliseconds);

    /**
     * Performs a <tt>usleep+time_nanosleep</tt> using this unit.
     * This is a convenience method that converts time arguments into the
     * form required by the <tt>sleep</tt> method.
     *
     * @param integer $timeout
     *            the minimum time to sleep. If less than
     *            or equal to zero, do not sleep at all.
     */
    function sleep(int $timeout): void {
        if (timeout > 0) {
            $milliseconds = $this->toMillis($timeout);
            $microseconds = bcmul($milliseconds, static::NANOSECOND_PER_MICROSECOND);
            $nanoseconds = $this->excessNanos($timeout, $milliseconds);
            usleep($microseconds);
            time_nanosleep($seconds = 0, $nanoseconds);
        }
    }

    /**
     * Returns the name of this TimeUnit class.
     *
     * @return string <code>__CLASS__</code>
     */
    function __toString(): string {
        return __CLASS__;
    }

}

class NANOSECONDS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return $duration;
    }

    function toMicros(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MICROSECOND, static::C0));
    }

    function toMillis(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MILLISECOND, static::C0));
    }

    function toSeconds(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::C0));
    }

    function toMinutes(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::C0));
    }

    function toHours(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::C0));
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::C0));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toNanos($d);
    }

    function excessNanos($duration, $milliseconds) {
        return bcsub($duration, bcmul($milliseconds, static::NANOSECOND_PER_MILLISECOND));
    }

}

class MICROSECONDS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MICROSECOND, static::C0));
    }

    function toMicros(int $duration): int {
        return $duration;
    }

    function toMillis(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MILLISECOND, static::NANOSECOND_PER_MICROSECOND));
    }

    function toSeconds(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMinutes(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_MICROSECOND));
    }

    function toHours(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MICROSECOND));
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MICROSECOND));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toMicros($d);
    }

    function excessNanos($duration, $milliseconds) {
        return bcsub(bcmul($duration, static::NANOSECOND_PER_MICROSECOND), bcmul($milliseconds, static::NANOSECOND_PER_MILLISECOND));
    }

}

class MILLISECONDS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MILLISECOND, static::C0));
    }

    function toMicros(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MILLISECOND, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMillis(int $duration): int {
        return $duration;
    }

    function toSeconds(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::NANOSECOND_PER_MILLISECOND));
    }

    function toMinutes(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_MILLISECOND));
    }

    function toHours(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MILLISECOND));
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MILLISECOND));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toMillis($d);
    }

    function excessNanos($duration, $milliseconds) {
        return 0;
    }

}

class SECONDS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::C0));
    }

    function toMicros(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMillis(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_SECOND, static::NANOSECOND_PER_MILLISECOND));
    }

    function toSeconds(int $duration): int {
        return $duration;
    }

    function toMinutes(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_SECOND));
    }

    function toHours(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_SECOND));
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_SECOND));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toSeconds($d);
    }

    function excessNanos($duration, $milliseconds) {
        return 0;
    }

}

class MINUTES extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::C0));
    }

    function toMicros(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMillis(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_MILLISECOND));
    }

    function toSeconds(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_MINUTE, static::NANOSECOND_PER_SECOND));
    }

    function toMinutes(int $duration): int {
        return $duration;
    }

    function toHours(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MINUTE));
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MINUTE));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toMinutes(d);
    }

    function excessNanos($duration, $milliseconds) {
        return 0;
    }

}

class HOURS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::C0));
    }

    function toMicros(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMillis(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MILLISECOND));
    }

    function toSeconds(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_SECOND));
    }

    function toMinutes(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_HOUR, static::NANOSECOND_PER_MINUTE));
    }

    function toHours(int $duration): int {
        return $duration;
    }

    function toDays(int $duration): int {
        return bcdiv($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_HOUR));
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toHours($d);
    }

    function excessNanos($duration, $milliseconds) {
        return 0;
    }

}

class DAYS extends TimeUnit {
    
    use Singleton;

    function toNanos(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::C0));
    }

    function toMicros(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MICROSECOND));
    }

    function toMillis(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MILLISECOND));
    }

    function toSeconds(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_SECOND));
    }

    function toMinutes(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_MINUTE));
    }

    function toHours(int $duration): int {
        return bcmul($duration, bcdiv(static::NANOSECOND_PER_DAY, static::NANOSECOND_PER_HOUR));
    }

    function toDays(int $duration): int {
        return $duration;
    }

    function convert($duration, TimeUnit $unit) {
        return $unit->toDays(d);
    }

    function excessNanos($duration, $milliseconds) {
        return 0;
    }

}