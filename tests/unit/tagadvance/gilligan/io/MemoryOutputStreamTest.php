<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class MemoryOutputStreamTest extends TestCase {
	
	function testWriteFlushAndClose() {
		$stream = new MemoryOutputStream();
		
		$written = $stream->write ( $string = 'abc' );
		$this->assertEquals ( $expected = strlen ( $string ), $actual = $written );
		$stream->flush ();
		
		$contents = $stream->getContents();
		$this->assertEquals ( $expected = $string, $actual = $contents);
		
		$stream->close ();
	}
	
}