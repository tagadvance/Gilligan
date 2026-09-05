<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\base\System;

/**
 * Wraps around and proxies assignments, dereferences, calls, and invocations to the value object.
 * Assignments and dereferences that would otherwise result in an "PHP Catchable fatal error: value object cannot have properties" are stored locally.
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

    public function removeObjectObserver(ObjectObserver $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function __get($name)
    {
        try {
            return isset($this->value->$name) ? $this->value->$name : $this->attributes[$name];
        } finally {
            $when = System::currentTimeMillis() / 1000;
            $event = new ObjectGetEvent($this->value, $when, $name);
            foreach ($this->observers as $observer) {
                $observer->onGet($event);
            }
        }
    }

    public function __set($name, $value)
    {
        try {
            if (isset($this->value->$name)) {
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

    public function __call($name, $arguments)
    {
        $function = [
            $this->value,
            $name,
        ];
        $arguments = func_get_args();
        try {
            return call_user_func($function, $arguments);
        } finally {
            $when = System::currentTimeMillis();
            $event = new ObjectCallEvent($this->value, $when, $name, $arguments);
            foreach ($this->observers as $observer) {
                $observer->onCall($event);
            }
        }
    }

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
