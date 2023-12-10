<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Blank;

class SingletonTest extends TestCase {
    
    function testGlobals() {
        $globals = Globals::getInstance();
        $this->assertNotNull($globals);
    }
    
    function testBlank() {
        $blank = Blank::getInstance();
        $this->assertNotNull($blank);
    }
    
}
