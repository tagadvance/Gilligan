<?php

namespace tagadvance\gilligan\io;

/**
 * A <code>php://memory</code> sink that can be read back, which is what makes it useful for
 * capturing output under test.
 * Nothing survives the object: the buffer goes when the handle is closed.
 */
class MemoryOutputStream extends ResourceOutputStream
{
    public function __construct()
    {
        $handle = fopen('php://memory', 'w+b');
        parent::__construct($handle);
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
     *        	start, which is what lets everything written so far be read
     *        	straight back.
     * @return string
     * @throws IOException when the read fails
     * @see http://php.net/manual/en/function.stream-get-contents.php
     */
    public function getContents(int $maxLength = -1, int $offset = 0)
    {
        $contents = stream_get_contents($this->handle, $maxLength, $offset);
        if ($contents === false) {
            throw new IOException(__METHOD__ . ' failed');
        }
        return $contents;
    }

}
