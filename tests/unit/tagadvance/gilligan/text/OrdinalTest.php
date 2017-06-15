<?php

namespace tagadvance\gilligan\text;

use PHPUnit\Framework\TestCase;

class OrdinalTest extends TestCase {
	
	function testSuffixTH() {
		$numbers = [ 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
		foreach ( $numbers as $number ) {
			$suffix = Ordinal::getSuffix ( $number );
			$this->assertEquals ( $expected = Ordinal::TH, $actual = $suffix );
		}
	}
	
	function testSuffixST() {
		$numbers = [ 1, 21, 31 ];
		foreach ( $numbers as $number ) {
			$suffix = Ordinal::getSuffix ( $number );
			$this->assertEquals ( $expected = Ordinal::ST, $actual = $suffix );
		}
	}
	
	function testSuffixND() {
		$numbers = [ 2, 22, 32 ];
		foreach ( $numbers as $number ) {
			$suffix = Ordinal::getSuffix ( $number );
			$this->assertEquals ( $expected = Ordinal::ND, $actual = $suffix );
		}
	}
	
	function testSuffixRD() {
		$numbers = [ 3, 23, 33 ];
		foreach ( $numbers as $number ) {
			$suffix = Ordinal::getSuffix ( $number );
			$this->assertEquals ( $expected = Ordinal::RD, $actual = $suffix );
		}
	}
	
}