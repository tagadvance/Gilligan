<?php

namespace tagadvance\gilligan\proxy;

use PHPUnit\Framework\TestCase;

class ObjectProxyTest extends TestCase {
    
    function testGet() {
        $source = new \stdClass();
        $source->foo = 'bar';
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onGet'])->getMock();
        $mock->expects($this->once())->method('onGet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo;
    }

    function testSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onSet'])->getMock();
        $mock->expects($this->once())->method('onSet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo = 'bar';
    }

    function testIsSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onIsSet'])->getMock();
        $mock->expects($this->once())->method('onIsSet');
        $proxy->addObjectObserver($mock);
        
        isset($proxy->foo);
    }

    function testUnset() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onUnset'])->getMock();
        $mock->expects($this->once())->method('onUnset');
        $proxy->addObjectObserver($mock);
        
        unset($proxy->foo);
    }

    function testCall() {
        $source = new class() extends \stdClass {
            function foo() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onCall'])->getMock();
        $mock->expects($this->once())->method('onCall');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo();
    }

    function testInvoke() {
        $source = new class() extends \stdClass {
            function __invoke() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder(ObjectObserverAdapter::class)->onlyMethods(['onInvoke'])->getMock();
        $mock->expects($this->once())->method('onInvoke');
        $proxy->addObjectObserver($mock);
        
        $proxy();
    }

}
