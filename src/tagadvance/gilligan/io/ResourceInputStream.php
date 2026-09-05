<?php

namespace tagadvance\gilligan\io;

/**
 * An {@link InputStream} over an already-open PHP stream resource.
 * It takes ownership: {@link self::close()} fcloses the handle the caller passed in.
 */
class ResourceInputStream implements InputStream
{
    protected $handle;

    /**
     * @throws \InvalidArgumentException when <code>$handle</code> is not a resource
     */
    public function __construct(/* resource */ $handle)
    {
        if (! is_resource($handle)) {
            $message = '$handle must be a resource';
            throw new \InvalidArgumentException($message);
        }

        $this->handle = $handle;
    }

    public function read(int $length): string
    {
        $read = fread($this->handle, $length);
        if ($read === false && feof($this->handle) === false) {
            throw new IOException();
        }
        return $read;
    }

    /**
     * Reads remainder of a stream into a string
     *
     * @param integer $maxLength
     *        	The maximum bytes to read. Defaults to -1 (read all the
     *        	remaining buffer).
     * @param integer $offset
     *        	Seek to the specified offset before reading. If this number is
     *        	negative, no seeking will occur and reading will start from
     *        	the current position. Note the default of 0 seeks back to the
     *        	start, unlike stream_get_contents(), whose own default of -1
     *        	reads on from wherever the stream stands.
     * @throws IOException when the read fails
     * @see http://php.net/manual/en/function.stream-get-contents.php
     */
    public function getContents(int $maxLength = -1, int $offset = 0): string
    {
        $contents = stream_get_contents($this->handle, $maxLength, $offset);
        if ($contents === false) {
            throw new IOException(__METHOD__ . ' failed');
        }
        return $contents;
    }

    public function seek(int $offset)
    {
        $seek = fseek($this->handle, $offset);
        if ($seek === -1) {
            throw new IOException();
        }
    }

    public function skip(int $offset)
    {
        $seek = fseek($this->handle, $offset, SEEK_CUR);
        if ($seek === -1) {
            throw new IOException();
        }
    }

    public function rewind()
    {
        $isReset = rewind($this->handle);
        if (! $isReset) {
            throw new IOException(__METHOD__ . ' failed');
        }
    }

    public function close()
    {
        $isClosed = fclose($this->handle);
        if (! $isClosed) {
            throw new IOException();
        }
    }

}
