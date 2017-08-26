<?php

namespace tagadvance\gilligan\tools;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Blank;

class FluentBuilderTest extends TestCase {

    function testExplicit() {
        $expected = 'ZYXDEF';
        $alphabet = FluentBuilder::valueOf('abcdef')->explicitStrReplace($search = 'abc', $replace = 'zyx', $subject = Blank::getInstance())->strtoupper();
        $this->assertEquals($expected, $actual = $alphabet());
    }

    function testImplicit1() {
        $oneThirdFloored = FluentBuilder::valueOf(5 / 3)->floor();
        $this->assertEquals($expected = 1, $actual = $oneThirdFloored());
    }

    function testImplicit2() {
        $expected = 'DEF';
        $alphabet = FluentBuilder::valueOf('abcdef')->substr($start = 3)->strtoupper();
        $this->assertEquals($expected, $actual = $alphabet());
    }

    function testStatic() {
        $expected = is_infinite(pi());
        $isPiInfinite = FluentBuilder::pi()->isInfinite();
        $this->assertEquals($expected, $actual = $isPiInfinite());
    }

}