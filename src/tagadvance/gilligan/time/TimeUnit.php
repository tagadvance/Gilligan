<?php

namespace tagadvance\gilligan\util;

use tagadvance\gilligan\base\Extensions;

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
    const C0 = 1;

    // nanosecond
    const C1 = 1000;

    // C0 * 1000; microsecond
    const C2 = 1000000;

    // C1 * 1000; millisecond
    const C3 = 1000000000;

    // C2 * 1000; second
    const C4 = 60000000000;

    // C3 * 60; minute
    const C5 = 3600000000000;

    // C4 * 60; hour
    const C6 = 86400000000000;

    // C5 * 24; day
    static function NANOSECONDS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new NANOSECONDS();
        }
        return $instance;
    }

    static function MICROSECONDS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new MICROSECONDS();
        }
        return $instance;
    }

    static function MILLISECONDS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new MILLISECONDS();
        }
        return $instance;
    }

    static function SECONDS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new SECONDS();
        }
        return $instance;
    }

    static function MINUTES() {
        static $instance = null;
        if ($instance == null) {
            $instance = new MINUTES();
        }
        return $instance;
    }

    static function HOURS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new HOURS();
        }
        return $instance;
    }

    static function DAYS() {
        static $instance = null;
        if ($instance == null) {
            $instance = new DAYS();
        }
        return $instance;
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
    abstract function convert($sourceDuration, TimeUnit $sourceUnit);

    /**
     * Equivalent to <tt>NANOSECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            integer the duration
     * @return integer the converted duration.
     */
    abstract function toNanos($duration);

    /**
     * Equivalent to <tt>MICROSECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMicros($duration);

    /**
     * Equivalent to <tt>MILLISECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMillis($duration);

    /**
     * Equivalent to <tt>SECONDS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toSeconds($duration);

    /**
     * Equivalent to <tt>MINUTES()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toMinutes($duration);

    /**
     * Equivalent to <tt>HOURS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration.
     */
    abstract function toHours($duration);

    /**
     * Equivalent to <tt>DAYS()->convert($duration, $this)</tt>.
     *
     * @param integer $duration
     *            the duration
     * @return integer the converted duration
     */
    abstract function toDays($duration);

    /**
     * Utility to compute the excess-nanosecond argument to sleep.
     *
     * @param integer $d
     *            the duration
     * @param integer $m
     *            the number of milliseconds
     * @return integer the number of nanoseconds
     */
    abstract function excessNanos($d, $m);

    /**
     * Performs a <tt>usleep+time_nanosleep</tt> using this unit.
     * This is a convenience method that converts time arguments into the
     * form required by the <tt>sleep</tt> method.
     *
     * @param integer $timeout
     *            the minimum time to sleep. If less than
     *            or equal to zero, do not sleep at all.
     */
    function sleep($timeout) {
        if (timeout > 0) {
            $milliseconds = $this->toMillis($timeout);
            $microseconds = bcmul($milliseconds, static::C1);
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

    function toNanos($d) {
        return $d;
    }

    function toMicros($d) {
        return bcdiv($d, bcdiv(static::C1, static::C0));
    }

    function toMillis($d) {
        return bcdiv($d, bcdiv(static::C2, static::C0));
    }

    function toSeconds($d) {
        return bcdiv($d, bcdiv(static::C3, static::C0));
    }

    function toMinutes($d) {
        return bcdiv($d, bcdiv(static::C4, static::C0));
    }

    function toHours($d) {
        return bcdiv($d, bcdiv(static::C5, static::C0));
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C0));
    }

    function convert($d, TimeUnit $u) {
        return $u->toNanos($d);
    }

    function excessNanos($d, $m) {
        return bcsub($d, bcmul($m, static::C2));
    }

}

class MICROSECONDS extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C1, static::C0));
    }

    function toMicros($d) {
        return $d;
    }

    function toMillis($d) {
        return bcdiv($d, bcdiv(static::C2, static::C1));
    }

    function toSeconds($d) {
        return bcdiv($d, bcdiv(static::C3, static::C1));
    }

    function toMinutes($d) {
        return bcdiv($d, bcdiv(static::C4, static::C1));
    }

    function toHours($d) {
        return bcdiv($d, bcdiv(static::C5, static::C1));
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C1));
    }

    function convert($d, TimeUnit $u) {
        return $u->toMicros($d);
    }

    function excessNanos($d, $m) {
        return bcsub(bcmul($d, static::C1), bcmul($m, static::C2));
    }

}

class MILLISECONDS extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C2, static::C0));
    }

    function toMicros($d) {
        return bcmul($d, bcdiv(static::C2, static::C1));
    }

    function toMillis($d) {
        return $d;
    }

    function toSeconds($d) {
        return bcdiv($d, bcdiv(static::C3, static::C2));
    }

    function toMinutes($d) {
        return bcdiv($d, bcdiv(static::C4, static::C2));
    }

    function toHours($d) {
        return bcdiv($d, bcdiv(static::C5, static::C2));
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C2));
    }

    function convert($d, TimeUnit $u) {
        return $u->toMillis($d);
    }

    function excessNanos($d, $m) {
        return 0;
    }

}

class SECONDS extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C3, static::C0));
    }

    function toMicros($d) {
        return bcmul($d, bcdiv(static::C3, static::C1));
    }

    function toMillis($d) {
        return bcmul($d, bcdiv(static::C3, static::C2));
    }

    function toSeconds($d) {
        return $d;
    }

    function toMinutes($d) {
        return bcdiv($d, bcdiv(static::C4, static::C3));
    }

    function toHours($d) {
        return bcdiv($d, bcdiv(static::C5, static::C3));
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C3));
    }

    function convert($d, TimeUnit $u) {
        return $u->toSeconds($d);
    }

    function excessNanos($d, $m) {
        return 0;
    }

}

class MINUTES extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C4, static::C0));
    }

    function toMicros($d) {
        return bcmul($d, bcdiv(static::C4, static::C1));
    }

    function toMillis($d) {
        return bcmul($d, bcdiv(static::C4, static::C2));
    }

    function toSeconds($d) {
        return bcmul($d, bcdiv(static::C4, static::C3));
    }

    function toMinutes($d) {
        return $d;
    }

    function toHours($d) {
        return bcdiv($d, bcdiv(static::C5, static::C4));
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C4));
    }

    function convert($d, TimeUnit $u) {
        return $u->toMinutes(d);
    }

    function excessNanos($d, $m) {
        return 0;
    }

}

class HOURS extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C5, static::C0));
    }

    function toMicros($d) {
        return bcmul($d, bcdiv(static::C5, static::C1));
    }

    function toMillis($d) {
        return bcmul($d, bcdiv(static::C5, static::C2));
    }

    function toSeconds($d) {
        return bcmul($d, bcdiv(static::C5, static::C3));
    }

    function toMinutes($d) {
        return bcmul($d, bcdiv(static::C5, static::C4));
    }

    function toHours($d) {
        return $d;
    }

    function toDays($d) {
        return bcdiv($d, bcdiv(static::C6, static::C5));
    }

    function convert($d, TimeUnit $u) {
        return $u->toHours($d);
    }

    function excessNanos($d, $m) {
        return 0;
    }

}

class DAYS extends TimeUnit {

    function toNanos($d) {
        return bcmul($d, bcdiv(static::C6, static::C0));
    }

    function toMicros($d) {
        return bcmul($d, bcdiv(static::C6, static::C1));
    }

    function toMillis($d) {
        return bcmul($d, bcdiv(static::C6, static::C2));
    }

    function toSeconds($d) {
        return bcmul($d, bcdiv(static::C6, static::C3));
    }

    function toMinutes($d) {
        return bcmul($d, bcdiv(static::C6, static::C4));
    }

    function toHours($d) {
        return bcmul($d, bcdiv(static::C6, static::C5));
    }

    function toDays($d) {
        return $d;
    }

    function convert($d, TimeUnit $u) {
        return $u->toDays(d);
    }

    function excessNanos($d, $m) {
        return 0;
    }

}