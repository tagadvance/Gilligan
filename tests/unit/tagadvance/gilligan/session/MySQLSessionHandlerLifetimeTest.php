<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;

/**
 * Unlike MySQLSessionHandlerTest, these need no database.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class MySQLSessionHandlerLifetimeTest extends TestCase
{
    private string $maxLifetime;

    public function setUp(): void
    {
        $this->maxLifetime = ini_get('session.gc_maxlifetime');
    }

    public function tearDown(): void
    {
        ini_set('session.gc_maxlifetime', $this->maxLifetime);
    }

    public function testMaxLifetimeHonorsIniSet(): void
    {
        ini_set('session.gc_maxlifetime', '60');

        $this->assertSame(60, $this->newHandler()->getMaxLifetime());
    }

    public function testMaxLifetimeIsNeverZero(): void
    {
        ini_set('session.gc_maxlifetime', '0');

        $this->assertSame(1440, $this->newHandler()->getMaxLifetime());
    }

    private function newHandler(): MySQLSessionHandler
    {
        $supplier = $this->createStub(PDOSupplier::class);

        return new MySQLSessionHandler($supplier, 'localhost');
    }
}
