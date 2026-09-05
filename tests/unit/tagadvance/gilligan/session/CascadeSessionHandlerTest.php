<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class CascadeSessionHandlerTest extends TestCase
{
    public const SESSION_ID = 'CAFEBABE';

    public function testConstructorWithNoArgumentsThrowsInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);

        new CascadeSessionHandler();
    }

    public function testConstructor()
    {
        $handler = $this->createStub(\SessionHandlerInterface::class);
        $handler = new CascadeSessionHandler($handler);
        $this->assertTrue(true);
    }

    public function testRead()
    {
        $handler1 = $handler = $this->createStub(\SessionHandlerInterface::class);
        $handler1->method('read')->willReturn($expected = 'foo');
        $handler2 = $handler = $this->createStub(\SessionHandlerInterface::class);
        $handler2->method('read')->willReturn('bar');

        $handler = new CascadeSessionHandler($handler1, $handler2);
        $actual = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected, $actual);
    }

    public function testReadOfStoredZero()
    {
        $handler1 = $this->createStub(\SessionHandlerInterface::class);
        $handler1->method('read')->willReturn($expected = '0');
        $handler2 = $this->createStub(\SessionHandlerInterface::class);
        $handler2->method('read')->willReturn('bar');

        $handler = new CascadeSessionHandler($handler1, $handler2);
        $this->assertSame($expected, $handler->read(self::SESSION_ID));
    }

    public function testReadFallsThroughAFailedHandler()
    {
        $handler1 = $this->createStub(\SessionHandlerInterface::class);
        $handler1->method('read')->willReturn(false);
        $handler2 = $this->createStub(\SessionHandlerInterface::class);
        $handler2->method('read')->willReturn($expected = 'bar');

        $handler = new CascadeSessionHandler($handler1, $handler2);
        $this->assertSame($expected, $handler->read(self::SESSION_ID));
    }

    public function testReadFallThrough()
    {
        $handler1 = $handler = $this->createStub(\SessionHandlerInterface::class);
        $handler1->method('read')->willReturn('');
        $handler2 = $handler = $this->createStub(\SessionHandlerInterface::class);
        $handler2->method('read')->willReturn($expected = 'bar');

        $handler = new CascadeSessionHandler($handler1, $handler2);
        $actual = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected, $actual);
    }

}
