<?php

namespace tagadvance\gilligan\collections;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\UnsupportedOperationException;

class ImmutableArrayTest extends TestCase
{
    private $immutableArray;

    public function setUp(): void
    {
        $this->immutableArray = new ImmutableArray([
            0 => 'zero',
            1 => 'one',
            'foo' => 'bar',
        ]);
    }

    public function testGet()
    {
        $this->assertEquals($expected = 'bar', $this->immutableArray['foo']);
    }

    public function testSetFails()
    {
        $this->expectException(UnsupportedOperationException::class);

        $this->immutableArray[] = new \stdClass();
    }

    public function testIsSet()
    {
        $this->assertTrue(isset($this->immutableArray['foo']));
    }

    public function testUnsetFails()
    {
        $this->expectException(UnsupportedOperationException::class);

        unset($this->immutableArray['foo']);
    }

}
