<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\base\System;

/**
 * Wraps around and proxies assignments, dereferences, calls, and invocations to the value object.
 * Assignments and dereferences that would otherwise result in an "PHP Catchable fatal error: value object cannot have properties" are stored locally.
 * Observers are notified from a <code>finally</code>, so they see an operation that threw as
 * well as one that succeeded.
 *
 * @author Tag Spilman <tagadvance+gilligan@gmail.com>
 */
class ObjectProxy
{
    private $value;

    private $attributes = [];

    private $observers = [];

    public function __construct(\stdClass $value)
    {
        $this->value = $value;
    }

    public function addObjectObserver(ObjectObserver $observer)
    {
        $this->observers[] = $observer;
    }

    /**
     * Matches loosely, so where two observers compare equal the first registered one is the one
     * dropped, whichever instance was passed.
     */
    public function removeObjectObserver(ObjectObserver $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    /**
     * Reads a real property of the wrapped object where one exists, otherwise the local
     * attribute bag; a name in neither warns and yields null.
     */
    public function __get($name)
    {
        try {
            return property_exists($this->value, $name) ? $this->value->$name : $this->attributes[$name];
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectGetEvent($this->value, $when, $name);
            foreach ($this->observers as $observer) {
                $observer->onGet($event);
            }
        }
    }

    /**
     * Writes through to a real property of the wrapped object where one exists; any other name
     * lands in the proxy's own attribute bag and is never visible on the wrapped object.
     */
    public function __set($name, $value)
    {
        try {
            if (property_exists($this->value, $name)) {
                $this->value->$name = $value;
            } else {
                $this->attributes[$name] = $value;
            }
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectSetEvent($this->value, $when, $name, $value);
            foreach ($this->observers as $observer) {
                $observer->onSet($event);
            }
        }
    }

    public function __isset($name)
    {
        try {
            return isset($this->value->$name) || isset($this->attributes[$name]);
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectIsSetEvent($this->value, $when, $name);
            foreach ($this->observers as $observer) {
                $observer->onIsSet($event);
            }
        }
    }

    public function __unset($name)
    {
        try {
            unset($this->value->$name, $this->attributes[$name]);
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectUnsetEvent($this->value, $when, $name);
            foreach ($this->observers as $observer) {
                $observer->onUnset($event);
            }
        }
    }

    /**
     * Forwards to the wrapped object, which therefore has to be a subclass of stdClass that
     * declares the method — a plain stdClass has none.
     */
    public function __call($name, $arguments)
    {
        $function = [
            $this->value,
            $name,
        ];
        try {
            return call_user_func_array($function, $arguments);
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectCallEvent($this->value, $when, $name, $arguments);
            foreach ($this->observers as $observer) {
                $observer->onCall($event);
            }
        }
    }

    /**
     * Calls the wrapped object, which therefore has to be a subclass of stdClass declaring
     * __invoke(); the arguments are forwarded but are not recorded on the event.
     */
    public function __invoke()
    {
        $arguments = func_get_args();
        try {
            return call_user_func_array($this->value, $arguments);
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectInvokeEvent($this->value, $when);
            foreach ($this->observers as $observer) {
                $observer->onInvoke($event);
            }
        }
    }

}
