<?php

namespace tagadvance\gilligan\text;

/**
 * This class is designed as a builder with a fluent interface to simplify
 * string construction and manipulation.
 * Every operation returns a new instance rather than mutating this one, and every one of them
 * works on bytes rather than characters, so multibyte text is not handled correctly.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
// TODO: character encoding methods, especially utf-8
// TODO: immutable
// TODO: cho[m]p
class StringClass
{
    public const WHITESPACE_CHARACTER_MASK = " \t\n\r\0\x0B";

    private $string;

    /**
     * This factory method allows one to chain method calls.
     *
     * @param mixed $string a StringClass is handed straight back, uncopied; anything else is
     *        coerced to string by the constructor
     */
    public static function valueOf($string): self
    {
        return $string instanceof self ? $string : new self($string);
    }

    /**
     * The inverse of {@link self::valueOf()}: unwraps a StringClass, casts anything else.
     */
    public static function toNativeString($string): string
    {
        return $string instanceof self ? $string->string : (string) $string;
    }

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    public function concatenate($string): self
    {
        $string = self::toNativeString($string);
        $concat = $this->string . $string;
        return new self($concat);
    }

    /**
     * @return bool true when $substring occurs anywhere; the empty string is always contained
     * @see http://php.net/manual/en/function.strpos.php
     */
    public function contains($substring): bool
    {
        $substring = self::toNativeString($substring);
        $position = strpos($this->string, $substring);
        return $position !== false;
    }

    /**
     * @see http://php.net/manual/en/function.strcmp.php
     */
    public function equals($string): bool
    {
        $string = self::toNativeString($string);
        return strcmp($this->string, $string) === 0;
    }

    /**
     * Case folding is ASCII-only, so accented letters do not compare equal to their
     * counterparts.
     *
     * @see http://php.net/manual/en/function.strcasecmp.php
     */
    public function equalsCaseInsensitive($string): bool
    {
        $string = self::toNativeString($string);
        return strcasecmp($this->string, $string) === 0;
    }

    /**
     * ASCII-only since PHP 8.2, so non-ASCII bytes are left as they are.
     *
     * @see http://php.net/manual/en/function.strtolower.php
     */
    public function toLowercase(): self
    {
        $lower = strtolower($this->string);
        return new self($lower);
    }

    /**
     * ASCII-only since PHP 8.2, so non-ASCII bytes are left as they are.
     *
     * @see http://php.net/manual/en/function.strtoupper.php
     */
    public function toUppercase(): self
    {
        $upper = strtoupper($this->string);
        return new self($upper);
    }

    /**
     * @param string $character_mask the characters to strip; the default covers whitespace plus
     *        NUL and vertical tab
     * @see http://php.net/manual/en/function.trim.php
     */
    public function trim(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self
    {
        $trim = trim($this->string, $character_mask);
        return new self($trim);
    }

    /**
     * @param string $character_mask the characters to strip; the default covers whitespace plus
     *        NUL and vertical tab
     * @see http://php.net/manual/en/function.ltrim.php
     */
    public function trimLeft(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self
    {
        $trim = ltrim($this->string, $character_mask);
        return new self($trim);
    }

    /**
     * @param string $character_mask the characters to strip; the default covers whitespace plus
     *        NUL and vertical tab
     * @see http://php.net/manual/en/function.rtrim.php
     */
    public function trimRight(string $character_mask = self::WHITESPACE_CHARACTER_MASK): self
    {
        $trim = rtrim($this->string, $character_mask);
        return new self($trim);
    }

    /**
     * @param int $offset byte offset at which the comparison starts
     * @return bool true when the prefix matches there; an empty prefix always matches
     */
    public function startsWith($prefix, int $offset = 0): bool
    {
        $prefix = self::toNativeString($prefix);
        $length = strlen($prefix);
        $start = substr($this->string, $offset, $length);
        return ($prefix === $start);
    }

    /**
     * @return bool true when the suffix matches; an empty suffix always matches
     */
    public function endsWith($suffix): bool
    {
        $suffix = self::toNativeString($suffix);
        $stringLength = strlen($this->string);
        $suffixLength = strlen($suffix);
        $start = $stringLength - $suffixLength;
        $substring = substr($this->string, $start);
        return ($suffix === $substring);
    }

    /**
     * @return int|false the byte offset of the first occurrence, or false if there is none —
     *         test with <code>!== false</code>, since offset 0 is a legitimate answer
     * @see http://php.net/manual/en/function.strpos.php
     */
    public function positionOf($string, int $offset = 0)
    {
        $string = self::toNativeString($string);
        return strpos($this->string, $string, $offset);
    }

    /**
     * @return int|false the byte offset of the last occurrence, or false if there is none —
     *         test with <code>!== false</code>, since offset 0 is a legitimate answer
     * @see http://php.net/manual/en/function.strrpos.php
     */
    public function lastPositionOf($string, int $offset = 0)
    {
        $string = self::toNativeString($string);
        return strrpos($this->string, $string, $offset);
    }

    public function isEmpty(): bool
    {
        return $this->string === '';
    }

    /**
     * @return int the length in bytes, which for non-ASCII text is more than the number of
     *         characters
     * @see http://php.net/manual/en/function.strlen.php
     */
    public function length(): int
    {
        return strlen($this->string);
    }

    /**
     * @param array $matches filled in by reference with the captured groups
     * @return int|false 1 on a match, 0 on none, or false — after a warning — when the pattern
     *         does not compile
     * @see http://php.net/manual/en/function.preg-match.php
     */
    public function match(string $pattern, ?array &$matches = null, int $flags = 0, int $offset = 0)
    {
        return preg_match($pattern, $this->string, $matches, $flags, $offset);
    }

    /**
     * A pattern that does not compile makes preg_split() return false, which this declared
     * return type turns into a TypeError rather than something the caller can test for.
     *
     * @param int $limit maximum pieces; -1, the default, means no limit
     * @return string[]
     */
    public function split(string $pattern, int $limit = -1, int $flags = 0): array
    {
        return preg_split($pattern, $this->string, $limit, $flags);
    }

    /**
     * Scans forward past each replacement, so a $new that contains $old is not rescanned.
     *
     * @param int|null $limit maximum replacements; null, the default, replaces every occurrence
     */
    // TODO: replace with str_replace($search, $replace, $subject)
    public function replace($old, $new, $limit = null)
    {
        $old = self::toNativeString($old);
        $new = self::toNativeString($new);
        $oldLength = strlen($old);
        $newLength = strlen($new);
        $string = $this->string;
        $offset = 0;
        for ($i = 0; $limit === null || $i < $limit; $i++) {
            $position = strpos($string, $old, $offset);
            if ($position === false) {
                break;
            }
            $string = substr_replace($string, $new, $position, $oldLength);
            $offset = $position + $newLength;
        }
        return new self($string);
    }

    /**
     * @see http://php.net/manual/en/function.strrev.php
     */
    public function reverse(): self
    {
        $reverse = strrev($this->string);
        return new self($reverse);
    }

    /**
     * @param int|null $limit maximum pieces; null, the default, means no limit
     * @return string[]
     * @throws \ValueError when $delimiter is the empty string
     */
    public function explode($delimiter, ?int $limit = null): array
    {
        $delimiter = self::toNativeString($delimiter);
        if ($limit === null) {
            return explode($delimiter, $this->string);
        }
        return explode($delimiter, $this->string, $limit);
    }

    /**
     *
     * @param int $fromIndex (inclusive)
     * @param int $toIndex (exclusive); null, the default, runs to the end
     * @throws \OutOfBoundsException when $toIndex is less than $fromIndex
     * @see http://php.net/manual/en/function.substr.php
     */
    public function substring(int $fromIndex, ?int $toIndex = null): self
    {
        if ($toIndex === null) {
            $toIndex = $this->length();
        } elseif ($toIndex < $fromIndex) {
            throw new \OutOfBoundsException("!($fromIndex <= $toIndex)");
        }
        $length = $toIndex - $fromIndex;
        $string = substr($this->string, $fromIndex, $length);
        return new self($string);
    }

    /**
     * Pads on both sides.
     *
     * @param int $length the total length wanted; a value no greater than the current length
     *        leaves the string untouched
     * @param mixed $string the padding, repeated and truncated to fit
     * @see http://php.net/manual/en/function.str-pad.php
     */
    public function pad(int $length, $string): self
    {
        $string = self::toNativeString($string);
        $result = str_pad($this->string, $length, $string, STR_PAD_BOTH);
        return new self($result);
    }

    /**
     * Pads on the left.
     *
     * @param int $length the total length wanted; a value no greater than the current length
     *        leaves the string untouched
     * @param mixed $string the padding, repeated and truncated to fit
     * @see http://php.net/manual/en/function.str-pad.php
     */
    public function padLeft(int $length, $string): self
    {
        $string = self::toNativeString($string);
        $result = str_pad($this->string, $length, $string, STR_PAD_LEFT);
        return new self($result);
    }

    /**
     * Pads on the right.
     *
     * @param int $length the total length wanted; a value no greater than the current length
     *        leaves the string untouched
     * @param mixed $string the padding, repeated and truncated to fit
     * @see http://php.net/manual/en/function.str-pad.php
     */
    public function padRight(int $length, $string): self
    {
        $string = self::toNativeString($string);
        $result = str_pad($this->string, $length, $string, STR_PAD_RIGHT);
        return new self($result);
    }

    public function __toString(): string
    {
        return $this->string;
    }

    /**
     * Same as {@link self::__toString()}, so an instance can stand in where a callable
     * returning the string is wanted.
     */
    public function __invoke()
    {
        return $this->string;
    }

    /**
     * Draws from rand(), which is not cryptographically secure — never use this for a token,
     * password or anything else that has to be unguessable.
     *
     * @param string $characters the alphabet to draw from, one byte per character
     */
    public static function random(int $length, string $characters = 'abcdefghijklmnopqrstuvwxyz0123456789'): self
    {
        $min = 0;
        $max = strlen($characters) - 1;

        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $index = rand($min, $max);
            $randomString .= $characters[$index];
        }

        return new self($randomString);
    }

}
