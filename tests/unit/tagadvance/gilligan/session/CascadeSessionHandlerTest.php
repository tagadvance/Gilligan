<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class CascadeSessionHandlerTest extends TestCase {

    const SESSION_ID = 'CAFEBABE';

    function testConstructorWithNoArgumentsThrowsInvalidArgumentException() {
        $this->expectException(\InvalidArgumentException::class);

        new CascadeSessionHandler();
    }

    function testConstructor() {
        $handler = $this->getMockBuilder(\SessionHandlerInterface::class)->getMock();
        $handler = new CascadeSessionHandler($handler);
        $this->assertTrue(true);
    }

    function testRead() {
        $handler1 = $handler = $this->getMockBuilder(\SessionHandlerInterface::class)->getMock();
        $handler1->method('read')->willReturn($expected = 'foo');
        $handler2 = $handler = $this->getMockBuilder(\SessionHandlerInterface::class)->getMock();
        $handler2->method('read')->willReturn('bar');
        
        $handler = new CascadeSessionHandler($handler1, $handler2);
        $actual = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected, $actual);
    }

    function testReadFallThrough() {
        $handler1 = $handler = $this->getMockBuilder(\SessionHandlerInterface::class)->getMock();
        $handler1->method('read')->willReturn('');
        $handler2 = $handler = $this->getMockBuilder(\SessionHandlerInterface::class)->getMock();
        $handler2->method('read')->willReturn($expected = 'bar');
        
        $handler = new CascadeSessionHandler($handler1, $handler2);
        $actual = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected, $actual);
    }

}
