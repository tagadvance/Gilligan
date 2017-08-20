<?php

namespace tagadvance\gilligan\collections;

use PHPUnit\Framework\TestCase;

class ImmutableArrayTest extends TestCase {

    private $array;

    function setUp() {
        $this->array = [
                0 => 'zero',
                1 => 'one',
                'foo' => 'bar'
        ];
    }

    /**
     * @expectedException tagadvance\gilligan\base\UnsupportedOperationException
     */
    function testSetFails() {
        $immutableArray = new ImmutableArray($this->array);
        $immutableArray[] = new \stdClass();
    }

    /**
     * @expectedException tagadvance\gilligan\base\UnsupportedOperationException
     */
    function testUnsetFails() {
        $immutableArray = new ImmutableArray($this->array);
        unset($immutableArray['foo']);
    }

}