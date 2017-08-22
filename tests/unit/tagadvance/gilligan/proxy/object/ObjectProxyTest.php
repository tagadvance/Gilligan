<?php

namespace tagadvance\gilligan\proxy\object;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Standard;

class ObjectProxyTest extends TestCase {

    function testFoo() {
        $source = new class() extends \stdClass {
            function foo() {}
            function __invoke() {}
        };
        $proxy = new ObjectProxy($source);
        $observer = new PrintObjectObserver(Standard::err(), $name = 'source');
        $proxy->addObjectObserver($observer);
        
        $proxy->foo = 'bar';
        $proxy->foo;
        if (isset($proxy->foo)) {
            unset($proxy->foo);
        }
        
        $proxy->foo();
        $proxy();
    }
    
    function testGet() {
        $source = new \stdClass();
        $source->foo = 'bar';
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onGet'])->getMock();
        $mock->expects($this->once())->method('onGet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo;
    }

    function testSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onSet'])->getMock();
        $mock->expects($this->once())->method('onSet');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo = 'bar';
    }

    function testIsSet() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onIsSet'])->getMock();
        $mock->expects($this->once())->method('onIsSet');
        $proxy->addObjectObserver($mock);
        
        isset($proxy->foo);
    }

    function testUnset() {
        $source = new \stdClass();
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onUnset'])->getMock();
        $mock->expects($this->once())->method('onUnset');
        $proxy->addObjectObserver($mock);
        
        unset($proxy->foo);
    }

    function testCall() {
        $source = new class() extends \stdClass {
            function foo() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onCall'])->getMock();
        $mock->expects($this->once())->method('onCall');
        $proxy->addObjectObserver($mock);
        
        $proxy->foo();
    }

    function testInvoke() {
        $source = new class() extends \stdClass {
            function __invoke() {}
        };
        $proxy = new ObjectProxy($source);
        
        $mock = $this->getMockBuilder('tagadvance\gilligan\proxy\object\ObjectObserverAdapter')->setMethods(['onInvoke'])->getMock();
        $mock->expects($this->once())->method('onInvoke');
        $proxy->addObjectObserver($mock);
        
        $proxy();
    }

}