<?php

namespace tagadvance\gilligan\err;

use PHPUnit\Framework\TestCase;

class ErrTest extends TestCase
{
    public function testInterceptErrorsInvokesHandler()
    {
        $handler = $this->createMock(ErrorHandler::class);
        $handler->expects($this->once())
            ->method('handleError')
            ->willReturn(true);

        Err::interceptErrors($handler);
        try {
            trigger_error('boom', E_USER_WARNING);
        } finally {
            restore_error_handler();
        }
    }

    public function testUncaughtExceptionHandlerAcceptsErrors()
    {
        $error = new \Error('boom');
        $handler = $this->createMock(UncaughtExceptionHandler::class);
        $handler->expects($this->once())
            ->method('handleException')
            ->with($error);

        $handler->handleException($error);
    }

}
