<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\io\PrintStream;

class PrintObjectObserver implements ObjectObserver {

    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private $out;

    private $name;

    function __construct(PrintStream $stream, string $name) {
        $this->out = $stream;
        $this->name = $name;
    }

    function onUnset(ObjectUnsetEvent $event) {
        $pattern = 'unset(%s->%s) at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    function onInvoke(ObjectInvokeEvent $event) {
        $pattern = 'invoke: %s() at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $when);
    }

    function onGet(ObjectGetEvent $event) {
        $pattern = 'get: %s->%s at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    function onCall(ObjectCallEvent $event) {
        $pattern = 'call: %s->%s(...) at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    function onIsSet(ObjectIsSetEvent $event) {
        $pattern = 'isset(%s->%s) at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    function onSet(ObjectSetEvent $event) {
        $pattern = 'set: %s->%s = %s at %s' . PHP_EOL;
        $when = date(self::DATE_FORMAT, $event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $event->getValue(), $when);
    }

}