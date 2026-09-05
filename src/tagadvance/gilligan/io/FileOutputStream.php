<?php

namespace tagadvance\gilligan\io;

/**
 * Opens a file for writing, creating it if it is not there.
 */
class FileOutputStream extends ResourceOutputStream
{
    /**
     * @param bool $append true to write at the end; the default truncates the file to zero
     *        length
     * @throws \InvalidArgumentException when the file cannot be opened, since the failed
     *         fopen() surfaces as a non-resource handle
     */
    public function __construct(File $file, $append = false)
    {
        $path = $file->getPathname();
        $mode = $append ? FileMode::WRITE_ONLY_APPEND : FileMode::WRITE_ONLY_TRUNCATE;
        $handle = fopen($path, $mode);
        parent::__construct($handle);
    }

}
