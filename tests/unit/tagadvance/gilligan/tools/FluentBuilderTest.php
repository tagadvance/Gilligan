<?php

namespace tagadvance\gilligan\tools;

use PHPUnit\Framework\TestCase;

class FluentBuilderTest extends TestCase {

    function test1() {
        $oneThirdFloored = FluentBuilder::valueOf(5 / 3)->floor();
        $this->assertEquals($expected = 1, $actual = $oneThirdFloored());
    }

    function test2() {
        $expected = is_infinite(pi());
        $isPiInfinite = FluentBuilder::pi()->isInfinite();
        $this->assertEquals($expected, $actual = $isPiInfinite());
    }

    function test3() {
        $expected = 'DEF';
        $alphabet = FluentBuilder::valueOf('abcdef')->substr($start = 3)->strtoupper();
        $this->assertEquals($expected, $actual = $alphabet());
    }

}