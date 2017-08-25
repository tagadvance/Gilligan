<?php

namespace tagadvance\gilligan\proxy;

use PHPUnit\Framework\TestCase;

class ArrayProxyTest extends TestCase {

    function testAsObject() {
        $array = [];
        $proxy = new ArrayProxy($array);
        
        $this->assertFalse(isset($proxy->foo));
        
        $proxy->foo = $expected = 'bar';
        $this->assertTrue(isset($proxy->foo));
        $this->assertEquals($expected, $actual = $proxy->foo);
        
        unset($proxy->foo);
        $this->assertFalse(isset($proxy->foo));
    }

    function testArrayAccess() {
        $array = [];
        $proxy = new ArrayProxy($array);
        
        $this->assertFalse(isset($proxy['foo']));
        
        $proxy['foo'] = $expected = 'bar';
        $this->assertTrue(isset($proxy['foo']));
        $this->assertEquals($expected, $actual = $proxy['foo']);
        
        unset($proxy['foo']);
        $this->assertFalse(isset($proxy['foo']));
    }

    function testPassThrough() {
        $array = [];
        $proxy = new ArrayProxy($array);
        $proxy->foo = 'bar';
        $this->assertTrue(isset($array['foo']));
    }

}