<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\cache\APC;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class APCSessionHandlerTest extends TestCase
{
    public const SESSION_ID = 'CAFEBABE';

    /**
     *
     * @var APCSessionHandler
     */
    private $handler;

    public function setUp(): void
    {
        apcu_clear_cache();

        $timeToLive = get_cfg_var('session.gc_maxlifetime');
        $apc = new APC($timeToLive);
        $this->handler = new APCSessionHandler($apc);
    }

    public function testReadAndWrite()
    {
        $writeData = 'foo';
        $this->handler->write(self::SESSION_ID, $writeData);

        $readData = $this->handler->read(self::SESSION_ID);

        $this->assertEquals($expected = $writeData, $actual = $readData);
    }

    public function testDestroy()
    {
        $this->handler->write(self::SESSION_ID, 'foo');
        $this->handler->destroy(self::SESSION_ID);
        $actual = $this->handler->read(self::SESSION_ID);
        $this->assertEquals($expected = '', $actual);
    }

    public function testGarbageCollection()
    {
        $this->handler->write(self::SESSION_ID, 'foo');
        $result = $this->handler->gc($maxLifetime = 0);
        $this->assertTrue($result);
    }

    public function tearDown(): void
    {
        apcu_clear_cache();
    }

}
