<?php

namespace tagadvance\gilligan\io;

/**
 * A readable, seekable byte source.
 */
interface InputStream extends Closeable
{
    /**
     * Reads up to <code>$length</code> bytes of data.
     *
     * @param integer $length The maximum number of bytes to be read.
     * @return string fewer than <code>$length</code> bytes is not an error, and the empty
     *         string means end of stream
     * @throws IOException when the read fails short of end of stream
     */
    public function read(int $length): string;

    /**
     * Moves to an absolute position; use {@link self::skip()} to move relative to the current
     * one.
     *
     * @throws IOException when the stream is not seekable
     * @see http://www.php.net/fseek
     */
    public function seek(int $offset);

    /**
     * Moves relative to the current position; a negative <code>$offset</code> moves backwards.
     *
     * @throws IOException when the stream is not seekable
     * @see http://www.php.net/fseek
     */
    public function skip(int $offset);

    /**
     * @throws IOException when the stream is not seekable
     * @see http://www.php.net/rewind
     */
    public function rewind();

}
