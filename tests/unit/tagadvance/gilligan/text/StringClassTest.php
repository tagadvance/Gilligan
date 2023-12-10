<?php

namespace tagadvance\gilligan\text;

use PHPUnit\Framework\TestCase;

class StringClassTest extends TestCase {
	
	function testValueOfString() {
		$value = StringClass::valueOf('0');
		$this->assertNotNull($value);
	}
	
	function testValueOfInteger() {
		$value = StringClass::valueOf(0);
		$this->assertNotNull($value);
	}
	
	function testToNativeValueWithRawString() {
		$expected = 'foo';
		$actual = StringClass::toNativeString($expected);
		$this->assertEquals($expected, $actual);
	}
	
	function testToNativeValueWithStringClass() {
		$expected = 'foo';
		$stringObject = new StringClass($expected);
		$actual = StringClass::toNativeString($stringObject);
		$this->assertEquals($expected, $actual);
	}
	
	function testConcatenateFooAndBar() {
		$foo = new StringClass ( 'foo' );
		$bar = new StringClass ( 'bar' );
		$foobar = $foo->concatenate ( $bar );
		$this->assertEquals ( $expected = 'foobar', $foobar () );
	}
	
	function testAlphabetContainsLMNOP() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->contains ( 'lmnop' );
		$this->assertTrue ( $actual );
	}
	
	function testAlphabetDoesNotContainZero() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->contains ( '0' );
		$this->assertFalse ( $actual );
	}
	
	function testAlphabetDoesNotContainCapitalABC() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->contains ( 'ABC' );
		$this->assertFalse ( $actual );
	}
	
	function testAlphabetEquals() {
		$lowerCaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
		$alphabet = new StringClass ( $lowerCaseAlphabet );
		$actual = $alphabet->equals ( $lowerCaseAlphabet );
		$this->assertTrue ( $actual );
	}
	
	function testAlphabetEqualsCaseSensitive() {
		$lowerCaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
		$upperCaseAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$alphabet = new StringClass ( $lowerCaseAlphabet );
		$actual = $alphabet->equals ( $upperCaseAlphabet );
		$this->assertFalse ( $actual );
	}
	
	function testAlphabetEqualsCaseInsensitive() {
		$lowerCaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
		$upperCaseAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$alphabet = new StringClass ( $lowerCaseAlphabet );
		$actual = $alphabet->equalsCaseInsensitive ( $upperCaseAlphabet );
		$this->assertTrue ( $actual );
	}
	
	function testAlphabetToUpperCase() {
		$lowerCaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
		$upperCaseAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$alphabet = new StringClass ( $lowerCaseAlphabet );
		$actual = $alphabet->toUpperCase ();
		$this->assertEquals ( $expected = $upperCaseAlphabet, $actual () );
	}
	
	function testAlphabetToLowerCase() {
		$lowerCaseAlphabet = 'abcdefghijklmnopqrstuvwxyz';
		$upperCaseAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$alphabet = new StringClass ( $upperCaseAlphabet );
		$actual = $alphabet->toLowerCase ();
		$this->assertEquals ( $expected = $lowerCaseAlphabet, $actual () );
	}
	
	function testTrim() {
		$expected = 'test';
		$string = new StringClass ( "\t $expected \t" );
		$actual = $string->trim ();
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testTrimLeft() {
		$expected = "test \t";
		$string = new StringClass ( "\t $expected" );
		$actual = $string->trimLeft ();
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testTrimRight() {
		$expected = "\t test";
		$string = new StringClass ( "$expected \t" );
		$actual = $string->trimRight ();
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testAlphabetStartsWithABC() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->startsWith ( 'abc' );
		$this->assertTrue ( $actual );
	}
	
	function testLowerCaseAlphabetDoesNotStartWithUpperCaseABC() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->startsWith ( 'ABC' );
		$this->assertFalse ( $actual );
	}
	
	function testAbcRepeatingStartsWithAbcAtOffset3() {
		$alphabet = new StringClass ( 'abcabcabc' );
		$actual = $alphabet->startsWith ( 'abc', $offset = 3 );
		$this->assertTrue ( $actual );
	}
	
	function testAbcRepeatingDoesNotStartWithAbcAtOffset2() {
		$alphabet = new StringClass ( 'abcabcabc' );
		$actual = $alphabet->startsWith ( 'abc', $offset = 2 );
		$this->assertFalse ( $actual );
	}
	
	function testAlphabetEndsWithXYZ() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->endsWith ( 'xyz' );
		$this->assertTrue ( $actual );
	}
	
	function testLowerCaseAlphabetDoesNotEndWithUpperCaseXYZ() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->startsWith ( 'XYZ' );
		$this->assertFalse ( $actual );
	}
	
	function testPositionOfAbcInAbcRepeating() {
		$alphabet = new StringClass ( 'abcABCabcABCabcABC' );
		$actual = $alphabet->positionOf ( 'ABC' );
		$this->assertEquals ( $expected = 3, $actual );
	}
	
	function testPositionOfAbcInAbcRepeatingStartingAtIndex5() {
		$alphabet = new StringClass ( 'abcABCabcABCabcABC' );
		$actual = $alphabet->positionOf ( 'ABC', $offset = 5 );
		$this->assertEquals ( $expected = 9, $actual );
	}
	
	function testLastPositionOfAbcInAbcRepeating() {
		$alphabet = new StringClass ( 'abcABCabcABCabcABC' );
		$actual = $alphabet->lastPositionOf ( 'ABC' );
		$this->assertEquals ( $expected = 15, $actual );
	}
	
	function testLastPositionOfAbcInAbcRepeatingStartingAtIndex9() {
		$alphabet = new StringClass ( 'abcABCabcABCabcABC' );
		$actual = $alphabet->lastPositionOf ( 'ABC', $offset = 9 );
		$this->assertEquals ( $expected = 15, $actual );
	}
	
	function testEmptyStringIsEmpty() {
		$string = new StringClass ( '' );
		$actual = $string->isEmpty ();
		$this->assertTrue ( $actual );
	}
	
	function testAStringIsNotEmpty() {
		$string = new StringClass ( ' ' );
		$actual = $string->isEmpty ();
		$this->assertFalse ( $actual );
	}
	
	function testEmptyStringLengthIs0() {
		$alphabet = new StringClass ( '' );
		$actual = $alphabet->length ();
		$this->assertEquals ( $expected = 0, $actual );
	}
	
	function testAlphabetLengthIs26() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->length ();
		$this->assertEquals ( $expected = 26, $actual );
	}
	
	function testAbcXyzRepeatingReplaceAllAbcWithFoo() {
		$alphabet = new StringClass ( 'abcXYZABCxyzabcXYZABCxyz' );
		$actual = $alphabet->replace ( 'abc', 'foo' );
		$expected = 'fooXYZABCxyzfooXYZABCxyz';
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testAbcXyzRepeatingReplaceAllAbcWithFooLimit0() {
		$alphabet = new StringClass ( 'abcXYZABCxyz' );
		$actual = $alphabet->replace ( 'abc', 'foo', $limit = 0 );
		$expected = 'abcXYZABCxyz';
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testAbcXyzRepeatingReplaceAllAbcWithFooLimit1() {
		$alphabet = new StringClass ( 'abcXYZABCxyzabcXYZABCxyz' );
		$actual = $alphabet->replace ( 'abc', 'foo', $limit = 1 );
		$expected = 'fooXYZABCxyzabcXYZABCxyz';
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testReverseAlphabet() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->reverse ();
		$expected = 'zyxwvutsrqponmlkjihgfedcba';
		$this->assertEquals ( $expected, $actual () );
	}
	
	function testExplodeOnCSV() {
		$string = new StringClass ( '1,2,3' );
		$actual = $string->explode ( $delimiter = ',' );
		$expected = [ 
				'1',
				'2',
				'3' 
		];
		$this->assertEquals ( $expected, $actual );
	}
	
	function testSplitOnCSV() {
		$string = new StringClass ( '1,2,3' );
		$actual = $string->split ( $pattern = '/[,]/' );
		$expected = [ 
				'1',
				'2',
				'3' 
		];
		$this->assertEquals ( $expected, $actual );
	}
	
	function testSubstringofAlphabetFromIndex23() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->substring ( $fromIndex = 23 );
		$this->assertEquals ( $expected = 'xyz', $actual );
	}
	
	function testSubstringofAlphabetFromIndex7ToIndex10() {
		$alphabet = new StringClass ( 'abcdefghijklmnopqrstuvwxyz' );
		$actual = $alphabet->substring ( $fromIndex = 7, $toIndex = 10 );
		$this->assertEquals ( $expected = 'hij', $actual );
	}
	
	function testPadWithOddNumberOfCharacters() {
		$string = new StringClass ( '1' );
		$string = $string->pad ( $length = 9, '0' );
		$expected = '000010000';
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testPadWithEvenNumberOfCharacters() {
		$string = new StringClass ( '1' );
		$string = $string->pad ( $length = 8, '0' );
		$expected = '00010000'; // note: 3x0; 1x1; 4x0
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testPadWithLengthLessThanNumberOfCharacters() {
		$expected = '123456789';
		$string = new StringClass ( $expected );
		$string = $string->pad ( $length = 5, '0' );
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testPadLeft0WithFour1s() {
		$expected = '00001';
		$string = new StringClass ( '1' );
		$string = $string->padLeft ( $length = 5, '0' );
		$this->assertEquals ( $expected, $actual = $string() );
	}
	
	function testPadLeftWithLengthLessThanNumberOfCharacters() {
		$expected = '123456789';
		$string = new StringClass ( $expected );
		$string = $string->padRight ( '0', $length = 5 );
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testPadRight0WithFour1s() {
		$expected = '10000';
		$string = new StringClass ( '1' );
		$string = $string->padRight ( $length = 5, '0' );
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testPadRightWithLengthLessThanNumberOfCharacters() {
		$expected = '123456789';
		$string = new StringClass ( $expected );
		$string = $string->padRight ( '0', $length = 5 );
		$this->assertEquals ( $expected, $actual = $string () );
	}
	
	function testRandom() {
		$tries = 10;
		$randomStrings = [ ];
		for($i = 0; $i < $tries; $i ++) {
			$randomStrings [] = StringClass::random ( $length = 16 )();
		}
		$unique = array_unique ( $randomStrings );
		$this->assertEquals ( $randomStrings, $unique );
	}
	
}
