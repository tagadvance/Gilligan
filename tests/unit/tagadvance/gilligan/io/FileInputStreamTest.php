<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class FileInputStreamTest extends TestCase {
	
	private $file;
	
	function setUp() {
		// dd if=/dev/zero of=input-test-data bs=1 count=8
		// dd if=/dev/urandom of=input-test-data bs=1 count=8 oflag=append conv=notrunc
		$fileName = __DIR__ . '/../../../../resources/input-test-data';
		$this->file = new File ( $fileName );
	}
	
	function testReadAndClose() {
		$stream = new FileInputStream ( $this->file );
		try {
			$string = $stream->read ( $length = 8 );
			$this->assertEquals ( $expected = $length, $actual = strlen ( $string ) );
			
			$stream->skip ( $offset = 4 );
			$string = $stream->read ( $length = 4 );
			$hex = bin2hex ( $string );
			$this->assertEquals ( $expected = '5936c5f7', $hex );
			
			$stream->seek ( $offset = 4 );
			$string = $stream->read ( $length = 10 );
			$hex = bin2hex ( $string );
			$this->assertEquals ( $expected = '000000009d9424965936', $hex );
		} finally {
			$stream->close ();
		}
		
		$contents = $stream->getContents ();
		$this->assertEquals ( $expected = $string, $actual = $contents );
	}
	
	function testGetContents() {
		$stream = new FileInputStream ( $this->file );
		try {
			$contents = $stream->getContents ();
			$hex = bin2hex ( $contents );
			$this->assertEquals ( $expected = '00000000000000009d9424965936c5f7', $hex );
		} finally {
			$stream->close ();
		}
	}
	
}