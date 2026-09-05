<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class MetaServerTest extends TestCase
{
    public function testHttpsIsFalseWhenVariableIsAbsent()
    {
        $server = new MetaServer([]);

        set_error_handler(function (int $errno, string $errstr): bool {
            throw new \ErrorException($errstr, 0, $errno);
        });
        try {
            $this->assertFalse($server->https());
        } finally {
            restore_error_handler();
        }
    }

    public function testHttpsIsTrueWhenVariableIsOn()
    {
        $server = new MetaServer([
            'HTTPS' => 'on',
        ]);

        $this->assertTrue($server->https());
    }

    public function testHttpsIsFalseWhenVariableIsOff()
    {
        $server = new MetaServer([
            'HTTPS' => 'off',
        ]);

        $this->assertFalse($server->https());
    }

}
