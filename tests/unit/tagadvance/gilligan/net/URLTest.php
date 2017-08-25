<?php

namespace tagadvance\gilligan\net;

use PHPUnit\Framework\TestCase;
use tagadvance\gilligan\base\MetaServer;

class URLTest extends TestCase {

    function testGetRequestURLHttp() {
        $expected = 'http://localhost?foo=bar';
        
        $server = new MetaServer([
                'HTTPS' => 'off',
                'HTTP_HOST' => 'localhost',
                'SERVER_PORT' => 80,
                'REQUEST_URI' => '?foo=bar'
        ]);
        $actual = URL::getRequestURL($server);
        
        $this->assertEquals($expected, $actual);
    }

    function testGetRequestURLHttps() {
        $expected = 'https://localhost?foo=bar';
        
        $server = new MetaServer([
                'HTTPS' => 'on',
                'HTTP_HOST' => 'localhost',
                'SERVER_PORT' => 443,
                'REQUEST_URI' => '?foo=bar'
        ]);
        $actual = URL::getRequestURL($server);
        
        $this->assertEquals($expected, $actual);
    }

    function testGetRequestURLWithHttpCustomPort() {
        $expected = 'http://localhost:8080?foo=bar';
        
        $server = new MetaServer([
                'HTTPS' => 'off',
                'HTTP_HOST' => 'localhost',
                'SERVER_PORT' => 8080,
                'REQUEST_URI' => '?foo=bar'
        ]);
        $actual = URL::getRequestURL($server);
        
        $this->assertEquals($expected, $actual);
    }

    function testGetRequestURLWithHttpsCustomPort() {
        $expected = 'https://localhost:8443?foo=bar';
        
        $server = new MetaServer([
                'HTTPS' => 'on',
                'HTTP_HOST' => 'localhost',
                'SERVER_PORT' => 8443,
                'REQUEST_URI' => '?foo=bar'
        ]);
        $actual = URL::getRequestURL($server);
        
        $this->assertEquals($expected, $actual);
    }

}