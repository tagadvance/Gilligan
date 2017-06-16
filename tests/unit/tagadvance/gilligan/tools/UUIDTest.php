<?php

namespace tagadvance\gilligan\tools;

use PHPUnit\Framework\TestCase;

class UUIDTest extends TestCase {
	
	function testV3() {
		$expected = '643dc989-58e9-3e72-9fd5-e3b4a09b62e9';
		$v3uuid = UUID::v3('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');
		$this->assertEquals($expected, $v3uuid);
	}
	
	function testV4() {
		$expected = 36;
		$v4uuid = UUID::v4 ();
		$this->assertEquals ( $expected, strlen ( $v4uuid ) );
	}
	
	function testV5() {
		$expected = 'c8333619-8220-5b21-b5d9-2bd56713675a';
		$v5uuid = UUID::v5('1546058f-5a25-4334-85ae-e68f2a44bbaf', 'SomeRandomString');
		$this->assertEquals($expected, $v5uuid);
	}
	
}