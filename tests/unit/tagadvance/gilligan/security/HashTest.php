<?php

namespace tagadvance\gilligan\security;

use PHPUnit\Framework\TestCase;

class HashTest extends TestCase {

	private $data;
	
	function setUp(): void {
		$filename = __DIR__ . '/../../../../resources/input-test-data';
		$this->data = file_get_contents($filename);
	}
	
	function testMD5() {
		$expected = '381f275286a3d086cba4b1d2ae8b3478';
		$md5 = Hash::md5($this->data);
		$this->assertEquals($expected, $md5);
	}

	function testSHA1() {
		$expected = 'd598e66151537a3204a57dd7e13800225cc8e318';
		$md5 = Hash::sha1($this->data);
		$this->assertEquals($expected, $md5);
	}

	function testSHA256() {
		$expected = 'e5bd8303cc015ada44b71c3abad5c260aaf73d022704e5259fc967e01a072a7c';
		$md5 = Hash::sha256($this->data);
		$this->assertEquals($expected, $md5);
	}

	function testSHA512() {
		$expected = 'd88fe776bb5628526540242551c09b8180e3884dc19a591e47bd2a4cae2f644d7420d56f7a97a8af468e9e0a7e17815ffd4025d92c43bfd7fdb94d29ccd4e63b';
		$md5 = Hash::sha512($this->data);
		$this->assertEquals($expected, $md5);
	}

}
