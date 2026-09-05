<?php

namespace tagadvance\gilligan\io;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
final class Closer
{
    private function __construct() {}

    /**
     * Closes the argument unless it is null, so a caller need not guard a stream that may
     * never have been opened.
     *
     * @throws IOException when the resource could not be released
     */
    public static function close(?Closeable $closeable = null)
    {
        if ($closeable !== null) {
            $closeable->close();
        }
    }

    /**
     * As {@link self::close()}, but discards an {@link IOException} — for use in a
     * <code>finally</code> where the real failure must not be masked.
     * Only IOException is swallowed; anything else still propagates.
     */
    public static function closeQuietly(?Closeable $closeable = null)
    {
        if ($closeable !== null) {
            try {
                $closeable->close();
            } catch (IOException $e) {
                // eat it
            }
        }
    }

}
