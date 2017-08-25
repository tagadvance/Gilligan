<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class APCSessionHandlerTest extends TestCase {

    const SESSION_ID = 'CAFEBABE';

    function setUp() {
        apc_clear_cache();
    }

    function testReadAndWrite() {
        $handler = new APCSessionHandler();
        $writeData = 'foo';
        $handler->write(self::SESSION_ID, $writeData);
        
        $readData = $handler->read(self::SESSION_ID);
        
        $this->assertEquals($expected = $writeData, $actual = $readData);
    }

    function testDestroy() {
        $handler = new APCSessionHandler();
        $handler->write(self::SESSION_ID, 'foo');
        $handler->destroy(self::SESSION_ID);
        $actual = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected = '', $actual);
    }

    function testGarbageCollection() {
        $handler = new APCSessionHandler();
        $handler->write(self::SESSION_ID, 'foo');
        $result = $handler->gc($maxLifetime = 0);
        $this->assertTrue($result);
    }

    function tearDown() {
        apc_clear_cache();
    }

}