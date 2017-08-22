<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class SingletonTest extends TestCase {

    function testGlobals() {
        $globals = Globals::getInstance();
        $this->assertNotNull($globals);
    }

    /**
     * @expectedException \Error
     */
    function testGlobalsConstructor() {
        $globals = new Globals();
    }

    /**
     * @expectedException \Error
     */
    function testGlobalsClone() {
        $globals = new Globals();
        clone ($globals);
    }

}