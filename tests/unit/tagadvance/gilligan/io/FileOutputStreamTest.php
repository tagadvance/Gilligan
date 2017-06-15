<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class FileOutputStreamTest extends TestCase {
	
	function testWriteFlushAndClose() {
		$fileName = 'foo';
		$file = File::createTemporaryFile ( $fileName );
		$stream = new FileOutputStream ( $file );
		$written = $stream->write ( $string = 'abc' );
		$this->assertEquals ( $expected = strlen ( $string ), $actual = $written );
		$stream->flush ();
		$stream->close ();
		
		$size = $file->getSize ();
		$this->assertEquals ( $expected, $actual = $size );
	}
	
}