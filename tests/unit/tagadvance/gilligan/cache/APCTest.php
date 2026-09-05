<?php

namespace tagadvance\gilligan\cache;

use PHPUnit\Framework\TestCase;

/**
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class APCTest extends TestCase
{
    private $apc;

    public function setUp(): void
    {
        if (!apcu_enabled()) {
            $this->markTestSkipped('APCu is not enabled on the CLI; run with apc.enable_cli=1');
        }

        $this->apc = new APC();
        $this->apc?->clear();
    }

    public function testSetAndGet()
    {
        $expected = 'bar';
        $this->apc->foo = $expected;
        $actual = $this->apc->foo;
        $this->assertEquals($expected, $actual);
    }

    public function testIsset()
    {
        $expected = false;
        $actual = isset($this->apc->foo);
        $this->assertEquals($expected, $actual);
    }

    public function testUnset()
    {
        $this->apc->foo = 'bar';
        $expected = true;
        $actual = isset($this->apc->foo);
        $this->assertEquals($expected, $actual);

        unset($this->apc->foo);
        $expected = false;
        $actual = isset($this->apc->foo);
        $this->assertEquals($expected, $actual);
    }

    public function tearDown(): void
    {
        $this->apc?->clear();
    }

}
