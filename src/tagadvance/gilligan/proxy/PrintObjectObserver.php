<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\io\PrintStream;

class PrintObjectObserver implements ObjectObserver
{
    private const DATE_FORMAT = 'Y-m-d H:i:s';

    private $out;

    private $name;

    public function __construct(PrintStream $stream, string $name)
    {
        $this->out = $stream;
        $this->name = $name;
    }

    /**
     * Events record milliseconds; date() expects seconds.
     */
    private static function formatWhen(int $when): string
    {
        return date(self::DATE_FORMAT, intdiv($when, 1000));
    }

    public function onUnset(ObjectUnsetEvent $event)
    {
        $pattern = 'unset(%s->%s) at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    public function onInvoke(ObjectInvokeEvent $event)
    {
        $pattern = 'invoke: %s() at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $when);
    }

    public function onGet(ObjectGetEvent $event)
    {
        $pattern = 'get: %s->%s at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    public function onCall(ObjectCallEvent $event)
    {
        $pattern = 'call: %s->%s(...) at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    public function onIsSet(ObjectIsSetEvent $event)
    {
        $pattern = 'isset(%s->%s) at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $when);
    }

    public function onSet(ObjectSetEvent $event)
    {
        $pattern = 'set: %s->%s = %s at %s' . PHP_EOL;
        $when = self::formatWhen($event->getWhen());
        $this->out->printFormatted($pattern, $this->name, $event->getName(), $event->getValue(), $when);
    }

}
