<?php

namespace tagadvance\gilligan\proxy;

use PHPUnit\Framework\TestCase;

class ObjectProxyTest extends TestCase {
    
    function testGet() {
        $source = new \stdClass();
        $source->foo = 'bar';
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onGet'])->getMock();
        $mock->expects($this->once())->method('onGet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo;
    }

    function testSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onSet'])->getMock();
        $mock->expects($this->once())->method('onSet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo = 'bar';
    }

    function testIsSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onIsSet'])->getMock();
        $mock->expects($this->once())->method('onIsSet');
        $proxy->addObjectObserver($mock);
        
        isset($proxy->foo);
    }

    function testUnset() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onUnset'])->getMock();
        $mock->expects($this->once())->method('onUnset');
        $proxy->addObjectObserver($mock);
        
        unset($proxy->foo);
    }

    function testCall() {
        $source = new class() extends \stdClass {
            function foo() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onCall'])->getMock();
        $mock->expects($this->once())->method('onCall');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo();
    }

    function testInvoke() {
        $source = new class() extends \stdClass {
            function __invoke() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->setMethods(['onInvoke'])->getMock();
        $mock->expects($this->once())->method('onInvoke');
        $proxy->addObjectObserver($mock);
        
        $proxy();
    }

}