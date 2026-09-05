<?php

namespace tagadvance\gilligan\proxy;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\io\MemoryOutputStream;
use tagadvance\gilligan\io\PrintStream;

class PrintObjectObserverTest extends TestCase
{
    private const WHEN_MILLIS = 1_000_000_000_123;

    private const WHEN_FORMATTED = '2001-09-09 01:46:40';

    private MemoryOutputStream $memory;

    private PrintObjectObserver $observer;

    protected function setUp(): void
    {
        date_default_timezone_set('UTC');
        $this->memory = new MemoryOutputStream();
        $this->observer = new PrintObjectObserver(new PrintStream($this->memory), 'source');
    }

    private function contents(): string
    {
        return $this->memory->getContents($maxLength = -1, $offset = 0);
    }

    public function testOnGet()
    {
        $event = new ObjectGetEvent(new \stdClass(), self::WHEN_MILLIS, 'foo');
        $this->observer->onGet($event);
        $this->assertEquals('get: source->foo at ' . self::WHEN_FORMATTED . PHP_EOL, $actual = $this->contents());
    }

    public function testOnSet()
    {
        $event = new ObjectSetEvent(new \stdClass(), self::WHEN_MILLIS, 'foo', 'bar');
        $this->observer->onSet($event);
        $expected = 'set: source->foo = bar at ' . self::WHEN_FORMATTED . PHP_EOL;
        $this->assertEquals($expected, $actual = $this->contents());
    }

    public function testOnIsSet()
    {
        $event = new ObjectIsSetEvent(new \stdClass(), self::WHEN_MILLIS, 'foo');
        $this->observer->onIsSet($event);
        $expected = 'isset(source->foo) at ' . self::WHEN_FORMATTED . PHP_EOL;
        $this->assertEquals($expected, $actual = $this->contents());
    }

    public function testOnUnset()
    {
        $event = new ObjectUnsetEvent(new \stdClass(), self::WHEN_MILLIS, 'foo');
        $this->observer->onUnset($event);
        $expected = 'unset(source->foo) at ' . self::WHEN_FORMATTED . PHP_EOL;
        $this->assertEquals($expected, $actual = $this->contents());
    }

    public function testOnCall()
    {
        $event = new ObjectCallEvent(new \stdClass(), self::WHEN_MILLIS, 'foo', []);
        $this->observer->onCall($event);
        $expected = 'call: source->foo(...) at ' . self::WHEN_FORMATTED . PHP_EOL;
        $this->assertEquals($expected, $actual = $this->contents());
    }

    public function testOnInvoke()
    {
        $event = new ObjectInvokeEvent(new \stdClass(), self::WHEN_MILLIS);
        $this->observer->onInvoke($event);
        $expected = 'invoke: source() at ' . self::WHEN_FORMATTED . PHP_EOL;
        $this->assertEquals($expected, $actual = $this->contents());
    }

}
