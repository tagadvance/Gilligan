<?php

namespace tagadvance\gilligan\cache;

use PHPUnit\Framework\TestCase;

/**
 * Note: this test requires `--define apc.enable_cli=1`
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class APCTest extends TestCase {
	
	private $apc;
	
	function setUp(): void {
		$this->apc = new APC ();
		$this->apc->clear ();
	}
	
	function testSetAndGet() {
		$expected = 'bar';
		$this->apc->foo = $expected;
		$actual = $this->apc->foo;
		$this->assertEquals ( $expected, $actual );
	}
	
	function testIsset() {
		$expected = false;
		$actual = isset ( $this->apc->foo );
		$this->assertEquals ( $expected, $actual );
	}
	
	function testUnset() {
		$this->apc->foo = 'bar';
		$expected = true;
		$actual = isset ( $this->apc->foo );
		$this->assertEquals ( $expected, $actual );
		
		unset ( $this->apc->foo );
		$expected = false;
		$actual = isset ( $this->apc->foo );
		$this->assertEquals ( $expected, $actual );
	}
	
	function tearDown(): void {
		$this->apc->clear ();
	}
	
}
