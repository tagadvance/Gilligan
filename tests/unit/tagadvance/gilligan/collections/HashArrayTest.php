<?php

namespace tagadvance\gilligan\collections;

use PHPUnit\Framework\TestCase;

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

}