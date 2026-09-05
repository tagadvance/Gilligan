<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class SystemTest extends TestCase
{
    public function testIsCLI()
    {
        $this->assertTrue(System::isCLI());
    }

    public function testIsCGI()
    {
        $this->assertFalse(System::isCGI());
    }

}
