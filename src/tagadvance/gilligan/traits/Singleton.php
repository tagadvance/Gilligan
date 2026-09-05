<?php

namespace tagadvance\gilligan\traits;

/**
 * Lazily memoized single instance, one per using class.
 * It constructs with <code>new self()</code>, so a subclass of a non-final user would hand back
 * an instance of the parent; every user in this library is <code>final</code>.
 */
trait Singleton
{
    /**
     * The instance, created on first call and held for the life of the process.
     */
    public static function getInstance(): self
    {
        static $instance = null;
        if ($instance === null) {
            $instance = new self();
        }
        return $instance;
    }

    private function __construct() {}

    /**
     * Private clone method to prevent cloning of the instance of the
     * *Singleton* instance.
     *
     * @see http://www.phptherightway.com/pages/Design-Patterns.html
     */
    private function __clone() {}

}
