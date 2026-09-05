<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class StandardTest extends TestCase
{
    public function testIn()
    {
        $in = Standard::in();
        $this->assertNotNull($in);
    }

    public function testOut()
    {
        $out = Standard::out();
        $this->assertNotNull($out);
    }

    public function testErr()
    {
        $err = Standard::err();
        $this->assertNotNull($err);
    }

    public function testOutput()
    {
        $out = Standard::output();
        $this->assertNotNull($out);
    }

}
