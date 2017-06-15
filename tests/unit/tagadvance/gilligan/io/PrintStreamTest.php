<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

class PrintStreamTest extends TestCase {
	
	function testPrint() {
		$delegatee = new MemoryOutputStream ();
		$stream = new PrintStream ( $delegatee );
		
		$written = $stream->print ( $string = 'abc' );
		$stream->flush ();
		$expected = strlen ( $string );
		$this->assertEquals ( $expected, $written );
		
		$stream->close ();
	}
	
	function testPrintLine() {
		$delegatee = new MemoryOutputStream ();
		$stream = new PrintStream ( $delegatee );
		
		$written = $stream->printLine ( $string = 'abc' );
		$stream->flush ();
		$expected = strlen ( $string ) + 1;
		$this->assertEquals ( $expected, $written );
		
		$stream->close ();
	}
	
	function testPrintFormatted() {
		$delegatee = new MemoryOutputStream ();
		$stream = new PrintStream ( $delegatee );
		
		$format = '%.4f';
		$written = $stream->printFormatted ( $format, pi () );
		$stream->flush ();
		$expected = strlen ( '3.1415' );
		$this->assertEquals ( $expected, $written );
		
		$stream->close ();
	}
	
}