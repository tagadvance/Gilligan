<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\Blank;

class SingletonTest extends TestCase
{
    public function testGlobals()
    {
        $globals = Globals::getInstance();
        $this->assertNotNull($globals);
    }

    public function testBlank()
    {
        $blank = Blank::getInstance();
        $this->assertNotNull($blank);
    }

}
