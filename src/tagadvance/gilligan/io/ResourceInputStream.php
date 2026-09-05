<?php

namespace tagadvance\gilligan\io;

class ResourceInputStream implements InputStream
{
    protected $handle;

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
        if ($read === false && feof($handle) === false) {
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
     *        	the current position.
     * @return string
     * @throws IOException
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
