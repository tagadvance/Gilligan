<?php

namespace tagadvance\gilligan\cache;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\text\ByteCountFormatter;

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

    public function testToHumanReadableStringIncludesCacheList()
    {
        $this->apc->foo = 'bar';

        $actual = $this->apc->__toString();

        $this->assertStringContainsString("'cache_list' => ", $actual);
        $this->assertStringContainsString("'info' => 'foo'", $actual);
    }

    public function testToHumanReadableStringPassesDecimalsToFormatter()
    {
        $this->apc->foo = 'bar';

        $formatter = new class implements ByteCountFormatter {
            public function format(int $byteCount, int $decimals): string
            {
                return "$byteCount:$decimals";
            }
        };
        $actual = $this->apc->toHumanReadableString($format = 'c', $formatter);

        $this->assertMatchesRegularExpression("/'mem_size' => '\\d+:2'/", $actual);
    }

    public function tearDown(): void
    {
        $this->apc?->clear();
    }

}
