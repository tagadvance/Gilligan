<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\cache\APC;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class APCSessionHandlerTest extends TestCase {

    const SESSION_ID = 'CAFEBABE';

    /**
     *
     * @var APCSessionHandler
     */
    private $handler;

    function setUp() {
        apcu_clear_cache();
        
        $timeToLive = get_cfg_var('session.gc_maxlifetime');
        $apc = new APC($timeToLive);
        $this->handler = new APCSessionHandler($apc);
    }

    function testReadAndWrite() {
        $writeData = 'foo';
        $this->handler->write(self::SESSION_ID, $writeData);
        
        $readData = $this->handler->read(self::SESSION_ID);
        
        $this->assertEquals($expected = $writeData, $actual = $readData);
    }

    function testDestroy() {
        $this->handler->write(self::SESSION_ID, 'foo');
        $this->handler->destroy(self::SESSION_ID);
        $actual = $this->handler->read(self::SESSION_ID);
        $this->assertEquals($expected = '', $actual);
    }

    function testGarbageCollection() {
        $this->handler->write(self::SESSION_ID, 'foo');
        $result = $this->handler->gc($maxLifetime = 0);
        $this->assertTrue($result);
    }

    function tearDown() {
        apcu_clear_cache();
    }

}