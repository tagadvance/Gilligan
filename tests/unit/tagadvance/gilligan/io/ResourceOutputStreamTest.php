<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class ResourceOutputStreamTest extends TestCase {
	
	function testWriteFlushAndClose() {
		$stream = ResourceOutputStream::createDefaultOutputStream();
		$written = $stream->write ( $string = 'abc' );
		$this->assertEquals ( $expected = strlen ( $string ), $actual = $written );
		$stream->flush ();
		$stream->close ();
	}
	
}