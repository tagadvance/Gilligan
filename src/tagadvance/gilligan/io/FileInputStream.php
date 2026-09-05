<?php

namespace tagadvance\gilligan\io;

/**
 * Opens a file read-only, positioned at the beginning.
 */
class FileInputStream extends ResourceInputStream
{
    /**
     * @throws \ValueError when the file does not exist, because the unresolvable real path
     *         reaches fopen() as an empty string
     */
    public function __construct(File $file)
    {
        $path = $file->getRealPath();
        $handle = fopen($path, FileMode::READ_ONLY);
        parent::__construct($handle);
    }

}
