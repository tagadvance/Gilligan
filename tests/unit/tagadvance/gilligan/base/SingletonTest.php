<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Blank;

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
    
    function testBlank() {
        $blank = Blank::getInstance();
        $this->assertNotNull($blank);
    }
    
    /**
     * @expectedException \Error
     */
    function testBlankConstructor() {
        $blank = new Blank();
    }
    
    /**
     * @expectedException \Error
     */
    function testBlankClone() {
        $blank = new Blank();
        clone ($blank);
    }
    
}