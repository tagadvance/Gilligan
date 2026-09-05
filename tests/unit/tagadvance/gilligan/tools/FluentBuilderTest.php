<?php

namespace tagadvance\gilligan\tools;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Blank;

class FluentBuilderTest extends TestCase
{
    public function testExplicit()
    {
        $expected = 'ZYXDEF';
        $alphabet = FluentBuilder::valueOf('abcdef')->explicitStrReplace($search = 'abc', $replace = 'zyx', $subject = Blank::getInstance())->strtoupper();
        $this->assertEquals($expected, $actual = $alphabet());
    }

    public function testImplicit1()
    {
        $oneThirdFloored = FluentBuilder::valueOf(5 / 3)->floor();
        $this->assertEquals($expected = 1, $actual = $oneThirdFloored());
    }

    public function testImplicit2()
    {
        $expected = 'DEF';
        $alphabet = FluentBuilder::valueOf('abcdef')->substr($start = 3)->strtoupper();
        $this->assertEquals($expected, $actual = $alphabet());
    }

    public function testImplicitUnderscoredFunctionName()
    {
        $encoded = FluentBuilder::valueOf('hello')->base64Encode();
        $this->assertEquals($expected = base64_encode('hello'), $actual = $encoded());
    }

    public function testStatic()
    {
        $expected = is_infinite(pi());
        $isPiInfinite = FluentBuilder::pi()->isInfinite();
        $this->assertEquals($expected, $actual = $isPiInfinite());
    }

}
