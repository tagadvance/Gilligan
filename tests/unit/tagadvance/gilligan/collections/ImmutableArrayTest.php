<?php

namespace tagadvance\gilligan\collections;

use PHPUnit\Framework\TestCase;

class ImmutableArrayTest extends TestCase {

    private $immutableArray;

    function setUp() {
        $this->immutableArray = new ImmutableArray([
                0 => 'zero',
                1 => 'one',
                'foo' => 'bar'
        ]);
    }

    function testGet() {
        $this->assertEquals($expected = 'bar', $this->immutableArray['foo']);
    }

    /**
     * @expectedException tagadvance\gilligan\base\UnsupportedOperationException
     */
    function testSetFails() {
        $this->immutableArray[] = new \stdClass();
    }

    function testIsSet() {
        $this->assertTrue(isset($this->immutableArray['foo']));
    }

    /**
     * @expectedException tagadvance\gilligan\base\UnsupportedOperationException
     */
    function testUnsetFails() {
        unset($this->immutableArray['foo']);
    }

}