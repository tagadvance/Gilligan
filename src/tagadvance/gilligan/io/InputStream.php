<?php

namespace tagadvance\gilligan\io;

interface InputStream extends Closeable
{
    /**
     * Reads up to <code>$length</code> bytes of data.
     *
     * @param integer $length The maximum number of bytes to be read.
     * @return string|boolean
     * @throws IOException
     */
    public function read(int $length): string;

    /**
     *
     * @throws IOException
     * @see http://www.php.net/fseek
     */
    public function seek(int $offset);

    /**
     *
     * @throws IOException
     * @see http://www.php.net/fseek
     */
    public function skip(int $offset);

    /**
     *
     * @throws IOException
     * @see http://www.php.net/rewind
     */
    public function rewind();

}
