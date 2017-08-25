<?php

namespace tagadvance\gilligan\collections;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\text\StringClass;

class HashArrayTest extends TestCase {

    function testArrayIsSetAndUnset() {
        $array = new HashArray();
        $key = new \stdClass();
        
        $this->assertFalse(isset($array[$key]));
        
        $array[$key] = true;
        
        $this->assertTrue(isset($array[$key]));
        
        unset($array[$key]);
        
        $this->assertFalse(isset($array[$key]));
    }

    function testArraySetAndGet() {
        $expected = 'value';
        
        $array = new HashArray();
        $key = new \stdClass();
        $array[$key] = $expected;
        
        // PHPUnit\Framework\Exception: Argument #1 (No Value) of PHPUnit\Framework\Assert::assertArrayHasKey() must be a integer or string
        // $this->assertArrayHasKey($key, $array);
        $this->assertEquals($expected, $array[$key]);
    }

    function testObjectIsSetAndUnset() {
        $array = new HashArray();
        // $key object must implement __toString
        $key = new StringClass('foo');
        
        $this->assertFalse(isset($array->$key));
        
        $array->$key = true;
        
        $this->assertTrue(isset($array->$key));
        
        unset($array->$key);
        
        $this->assertFalse(isset($array->$key));
    }

    function testObjectSetAndGetWithObjectImplementsToString() {
        $expected = 'value';
        
        $array = new HashArray();
        // $key object must implement __toString
        $key = new StringClass('foo');
        $array->$key = $expected;
        
        $this->assertEquals($expected, $array->$key);
    }

}