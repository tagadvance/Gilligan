<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class StandardTest extends TestCase {
	
	function testIn() {
		$in = Standard::in();
		$this->assertNotNull($in);
	}
	
	function testOut() {
		$out = Standard::out();
		$this->assertNotNull($out);
	}
	
	function testErr() {
		$err= Standard::err();
		$this->assertNotNull($err);
	}
	
	function testOutput() {
		$out = Standard::output();
		$this->assertNotNull($out);
	}
	
}