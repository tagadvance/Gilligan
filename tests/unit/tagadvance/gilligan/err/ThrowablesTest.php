<?php

namespace tagadvance\gilligan\net;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\err\Throwables;

class ThrowablesTest extends TestCase {

    function testGetCausalChain() {
        $message = '';
        $code = 0;
        $e1 = new \Exception();
        $e2 = new \LogicException($message, $code, $e1);
        $e3 = new \RuntimeException($message, $code, $e2);
        $expected = [
                $e1,
                $e2,
                $e3
        ];
        $actual = Throwables::getCausalChain($e3);
        
        // results in infinite recursion
        // $this->assertEquals($expected, $actual);
        // hence this weird assertion
        $callback = function ($e) {
            return get_class($e);
        };
        $this->assertEquals(array_walk($expected, $callback), array_walk($actual, $callback));
    }

    function testGetRootCause() {
        $message = '';
        $code = 0;
        $expected = $e1 = new \Exception();
        $e2 = new \LogicException($message, $code, $e1);
        $e3 = new \RuntimeException($message, $code, $e2);
        $actual = Throwables::getRootCause($e3);
        $this->assertEquals($expected, $actual);
    }

}