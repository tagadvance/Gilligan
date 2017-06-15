<?php

namespace tagadvance\gilligan\cache;

use PHPUnit\Framework\TestCase;

class APCTest extends TestCase {
	
	function test() {
		$apc = new APC();
		
		$condition = isset($apc->foo);
		$this->assertFalse($condition);
		
		$apc->foo = 'bar';
		$condition = isset($apc->foo);
		$this->assertTrue($condition);
		
		$string = $apc->__toString();
		$this->assertNotNull($string);
		
		unset($apc->foo);
		$condition = isset($apc->foo);
		$this->assertFalse($condition);
	}
	
}