<?php

namespace tagadvance\gilligan\text;

/**
 * This class is designed as a builder with a fluent interface to simplify
 * string construction and manipulation.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
// TODO: character encoding methods, especially utf-8
// TODO: immutable
// TODO: cho[m]p
class StringClass {

	const WHITESPACE_CHARACTER_MASK = " \t\n\r\0\x0B";

	private $string;

	/**
	 * This factory method allows one to chain method calls.
	 *
	 * @param mixed $string        	
	 * @return \tagadvance\gilligan\base\StringClass
	 */
	static function valueOf($string): self {
		return $string instanceof self ? $string : new self ( $string );
	}
	
	static function toNativeString($string): string {
		return $string instanceof self ? $string->string : (string) $string;
	}

	function __construct(string $string) {
		$this->string = $string;
	}

	/**
	 * 
	 * @param mixed $string
	 * @return self
	 */
	function concatenate($string): self {
		$string = self::toNativeString ( $string );
		$concat = $this->string . $string;
		return new self ( $concat );
	}

	/**
	 * 
	 * @param unknown $substring
	 * @return bool
	 * @see http://php.net/manual/en/function.strpos.php
	 */
	function contains($substring): bool {
		$substring = self::toNativeString ( $substring );
		$position = strpos ( $this->string, $substring );
		return $position !== false;
	}

	/**
	 * 
	 * @param mixed $string
	 * @return bool
	 * @see http://php.net/manual/en/function.strcmp.php
	 */
	function equals($string): bool {
		$string = self::toNativeString ( $string );
		return strcmp ( $this->string, $string ) === 0;
	}
	
	/**
	 * 
	 * @param mixed $string
	 * @return bool
	 * @see http://php.net/manual/en/function.strcasecmp.php
	 */
	function equalsCaseInsensitive ($string): bool {
		$string = self::toNativeString ( $string );
		return strcasecmp ( $this->string, $string ) === 0;
	}

	/**
	 * 
	 * @return self
	 * http://php.net/manual/en/function.strtolower.php
	 */
	function toLowercase(): self {
		$lower = strtolower ( $this->string );
		return new self ( $lower );
	}

	/**
	 * 
	 * @return self
	 * http://php.net/manual/en/function.strtoupper.php
	 */
	function toUppercase(): self {
		$upper = strtoupper ( $this->string );
		return new self ( $upper );
	}

	/**
	 * 
	 * @param string $character_mask
	 * @return self
	 * @see http://php.net/manual/en/function.trim.php
	 */
	function trim(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self {
		$trim = trim ( $this->string, $character_mask );
		return new self ( $trim );
	}

	/**
	 * 
	 * @param string $character_mask
	 * @return self
	 * @see http://php.net/manual/en/function.ltrim.php
	 */
	function trimLeft(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self {
		$trim = ltrim ( $this->string, $character_mask );
		return new self ( $trim );
	}

	/**
	 * 
	 * @param string $character_mask
	 * @return self
	 * @see http://php.net/manual/en/function.rtrim.php
	 */
	function trimRight(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self {
		$trim = rtrim ( $this->string, $character_mask );
		return new self ( $trim );
	}

	/**
	 * 
	 * @param mixed $prefix
	 * @param int $offset
	 * @return bool
	 */
	function startsWith($prefix, int $offset = 0): bool {
		$prefix = self::toNativeString ( $prefix );
		$length = strlen ( $prefix );
		$start = substr ( $this->string, $offset, $length );
		return ($prefix === $start);
	}

	/**
	 * 
	 * @param mixed $suffix
	 * @return bool
	 */
	function endsWith($suffix): bool {
		$suffix = self::toNativeString ( $suffix );
		$stringLength = strlen ( $this->string );
		$suffixLength = strlen ( $suffix );
		$start = $stringLength - $suffixLength;
		$substring = substr ( $this->string, $start );
		return ($suffix === $substring);
	}

	/**
	 * 
	 * @param unknown $string
	 * @param int $offset
	 * @return mixed
	 * @see http://php.net/manual/en/function.strpos.php
	 */
	function positionOf($string, int $offset = 0) {
		$string = self::toNativeString ( $string );
		return strpos ( $this->string, $string, $offset );
	}
	
	/**
	 *
	 * @param unknown $string
	 * @param int $offset
	 * @return mixed
	 * @see http://php.net/manual/en/function.strrpos.php
	 */
	function lastPositionOf($string, int $offset = 0) {
		$string = self::toNativeString ( $string );
		return strrpos ( $this->string, $string, $offset );
	}

	/**
	 * 
	 * @return bool
	 * @see http://php.net/manual/en/function.empty.php
	 */
	function isEmpty(): bool {
		return empty ( $this->string );
	}

	/**
	 * 
	 * @return number
	 * @see http://php.net/manual/en/function.strlen.php
	 */
	function length(): int {
		return strlen ( $this->string );
	}
	
	/**
	 * 
	 * @param string $pattern
	 * @param array $matches
	 * @param int $flags
	 * @param int $offset
	 * @return number
	 * @see http://php.net/manual/en/function.preg-match.php
	 */
	function match(string $pattern, array &$matches = null, int $flags = null, int $offset = null) {
		return preg_match ( $pattern, $this->string, $matches, $flags, $offset );
	}
	
	/**
	 * 
	 * @param string $pattern
	 * @param int $limit
	 * @param int $flags
	 * @return array
	 */
	function split(string $pattern, int $limit = null, int $flags = null): array {
		return preg_split ( $pattern, $this->string, $limit, $flags );
	}

	// TODO: replace with str_replace($search, $replace, $subject)
	function replace($old, $new, $limit = null) {
		$old = self::toNativeString ( $old );
		$new = self::toNativeString ( $new );
		$oldLength = strlen ( $old );
		$newLength = strlen ( $new );
		$string = $this->string;
		$offset = 0;
		for ($i = 0; $limit === null || $i < $limit; $i ++) {
			$position = strpos ( $string, $old, $offset );
			if ($position === false) {
				break;
			}
			$string = substr_replace ( $string, $new, $position, $oldLength );
			$offset += $position + $newLength;
		}
		return new self ( $string );
	}

	/**
	 * 
	 * @return self
	 * @see http://php.net/manual/en/function.strrev.php
	 */
	function reverse(): self {
		$reverse = strrev ( $this->string );
		return new self ( $reverse );
	}
	
	/**
	 *
	 * @param mixed $delimiter        	
	 * @param int $limit        	
	 * @return array
	 */
	function explode($delimiter, int $limit = null): array {
		$delimiter = self::toNativeString ( $delimiter );
		if ($limit == null) {
			return explode ( $delimiter, $this->string );
		}
		return explode ( $delimiter, $this->string, $limit );
	}
	
	/**
	 * 
	 * @param int $fromIndex (inclusive)
	 * @param int $toIndex (exclusive)
	 * @throws OutOfBoundsException
	 * @return self
	 * @see http://php.net/manual/en/function.substr.php
	 */
	function substring(int $fromIndex, int $toIndex = null): self {
		if ($toIndex == null) {
			$toIndex = $this->length ();
		} else if ($toIndex < $fromIndex) {
			throw new \OutOfBoundsException ( "!($fromIndex <= $toIndex)" );
		}
		$length = $toIndex - $fromIndex;
		$string = substr ( $this->string, $fromIndex, $length );
		return new self ( $string );
	}

	/**
	 * 
	 * @param int $length
	 * @param mixed $string
	 * @return self
	 * @see http://php.net/manual/en/function.str-pad.php
	 */
	function pad(int $length, $string): self {
		$string = self::toNativeString ( $string );
		$result = str_pad ( $this->string, $length, $string, STR_PAD_BOTH );
		return new self ( $result );
	}

	/**
	 *
	 * @param int $length
	 * @param mixed $string
	 * @return self
	 * @see http://php.net/manual/en/function.str-pad.php
	 */
	function padLeft(int $length, $string): self {
		$string = self::toNativeString ( $string );
		$result = str_pad ( $this->string, $length, $string, STR_PAD_LEFT );
		return new self ( $result );
	}

	/**
	 *
	 * @param int $length
	 * @param mixed $string
	 * @return self
	 * @see http://php.net/manual/en/function.str-pad.php
	 */
	function padRight(int $length, $string): self {
		$string = self::toNativeString ( $string );
		$result = str_pad ( $this->string, $length, $string, STR_PAD_RIGHT );
		return new self ( $result );
	}

	function __toString() {
		return $this->string;
	}

	function __invoke() {
		return $this->string;
	}

	/**
	 * 
	 * @param int $length
	 * @param string $characters
	 * @return self a random string
	 */
	static function random(int $length, $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'): self {
		$min = 0;
		$max = strlen ( $characters ) - 1;
		
		$randomString = '';
		for ($i = 0; $i < $length; $i ++) {
			$index = rand ( $min, $max );
			$randomString .= $characters {$index};
		}
		
		return new self ( $randomString );
	}

}