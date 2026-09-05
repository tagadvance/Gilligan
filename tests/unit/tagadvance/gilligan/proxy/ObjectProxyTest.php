<?php

namespace tagadvance\gilligan\proxy;

use PHPUnit\Framework\TestCase;

class ObjectProxyTest extends TestCase
{
    public function testGet()
    {
        $source = new \stdClass();
        $source->foo = 'bar';
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onGet'])->getMock();
        $mock->expects($this->once())->method('onGet');
        $proxy->addObjectObserver($mock);

        $proxy->foo;
    }

    public function testSet()
    {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onSet'])->getMock();
        $mock->expects($this->once())->method('onSet');
        $proxy->addObjectObserver($mock);

        $proxy->foo = 'bar';
    }

    public function testGetNullValuedProperty()
    {
        $source = new \stdClass();
        $source->foo = null;
        $proxy = new ObjectProxy($source);

        $this->assertNull($actual = $proxy->foo);
    }

    public function testSetNullValuedPropertyWritesThrough()
    {
        $source = new \stdClass();
        $source->foo = null;
        $proxy = new ObjectProxy($source);

        $proxy->foo = $expected = 'bar';

        $this->assertEquals($expected, $actual = $source->foo);
        $this->assertEquals($expected, $actual = $proxy->foo);
    }

    public function testIsSet()
    {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onIsSet'])->getMock();
        $mock->expects($this->once())->method('onIsSet');
        $proxy->addObjectObserver($mock);

        isset($proxy->foo);
    }

    public function testUnset()
    {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onUnset'])->getMock();
        $mock->expects($this->once())->method('onUnset');
        $proxy->addObjectObserver($mock);

        unset($proxy->foo);
    }

    public function testCall()
    {
        $source = new class extends \stdClass {
            public function foo() {}
        };
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onCall'])->getMock();
        $mock->expects($this->once())->method('onCall');
        $proxy->addObjectObserver($mock);

        $proxy->foo();
    }

    public function testCallForwardsArgumentsIndividually()
    {
        $source = new class extends \stdClass {
            public function concat(string $a, string $b): string
            {
                return $a . $b;
            }
        };
        $proxy = new ObjectProxy($source);

        $observer = new class extends ObjectObserverAdapter {
            public array $arguments = [];

            public function onCall(ObjectCallEvent $event)
            {
                $this->arguments = $event->getArguments();
            }
        };
        $proxy->addObjectObserver($observer);

        $this->assertEquals('ab', $actual = $proxy->concat('a', 'b'));
        $this->assertEquals(['a', 'b'], $actual = $observer->arguments);
    }

    public function testInvoke()
    {
        $source = new class extends \stdClass {
            public function __invoke() {}
        };
        $proxy = new ObjectProxy($source);

        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onInvoke'])->getMock();
        $mock->expects($this->once())->method('onInvoke');
        $proxy->addObjectObserver($mock);

        $proxy();
    }

}
