<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class FileInputStreamTest extends TestCase {
	
	function testReadAndClose() {
		// dd if=/dev/zero of=input-test-data bs=1 count=8
		// dd if=/dev/urandom of=input-test-data bs=1 count=8 oflag=append conv=notrunc
		
		$fileName = __DIR__ . '/../../../../resources/input-test-data';
		$file = new File($fileName);
		$stream = new FileInputStream ( $file );
		
		$string = $stream->read($length = 8);
		$this->assertEquals ( $expected = $length, $actual = strlen($string) );
		
		$stream->skip($offset = 4);
		$string = $stream->read($length = 4);
		$hex = bin2hex ( $string);
		$this->assertEquals ( $expected = '5936c5f7', $hex);
		
		$stream->seek($offset = 4);
		$string = $stream->read($length = 10);
		$hex = bin2hex ( $string);
		$this->assertEquals ( $expected = '000000009d9424965936', $hex);
		
		$stream->close();
	}
	
}