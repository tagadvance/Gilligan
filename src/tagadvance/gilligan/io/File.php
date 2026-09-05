<?php

namespace tagadvance\gilligan\io;

use tagadvance\gilligan\base\System;
use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\text\StringClass;

Extensions::getInstance()->requires('SPL');

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see http://www.php.net/manual/en/splfileinfo.getfileinfo.php
 */
class File extends \SplFileInfo
{
    public const separator = DIRECTORY_SEPARATOR;

    public const pathSeparator = PATH_SEPARATOR;

    public const hiddenFilePrefix = '.';

    private $fileName;

    public function __construct($fileName)
    {
        parent::__construct($fileName);
        $this->fileName = $fileName;
    }

    /**
     * Creates a new, empty file named by this abstract pathname if and only if
     * a file with this name does not yet exist.
     *
     * @return boolean
     */
    public function touch(): bool
    {
        if (file_exists($this->fileName)) {
            return false;
        }
        return touch($this->fileName);
    }

    public function delete()
    {
        return unlink($this->fileName);
    }

    public function deleteOnExit()
    {
        register_shutdown_function(function () {
            $this->delete();
        });
    }

    public function getParent(): string
    {
        return dirname($this->fileName);
    }

    public function getParentFile(): self
    {
        $parent = $this->getParent();
        return new File($parent);
    }

    public function isHidden(): bool
    {
        $baseName = basename($this->fileName);
        ;
        $fileName = new StringClass($baseName);
        return $fileName->startsWith(self::hiddenFilePrefix);
    }

    public function isDirectory(): bool
    {
        return $this->isDir();
    }

    /**
     * Alias of <code>SplFileInfo::getMTime</code>.
     *
     * @return integer Unix timestamp
     * @see http://www.php.net/manual/en/splfileinfo.getmtime.php
     */
    public function getModifiedTime(): int
    {
        return parent::getMTime();
    }

    /**
     * Returns the size of the partition named by this path.
     *
     * @return float
     * @see http://php.net/disk_total_space
     */
    public function getTotalSpace(): float
    {
        $directory = $this->isDirectory() ? $this->fileName : $this->getParent();
        return disk_total_space($directory);
    }

    /**
     * Returns the number of unallocated bytes in the partition named by this
     * path.
     *
     * @return float
     * @see http://php.net/disk_free_space
     */
    public function getFreeSpace()
    {
        $directory = $this->isDirectory() ? $this->fileName : $this->getParent();
        return disk_free_space($directory);
    }

    /**
     *
     * @param string $fileName
     * @param string $directory
     * @throws IOException
     * @return self
     */
    public static function createTemporaryFile(string $fileName, ?string $directory = null): self
    {
        if ($directory === null) {
            $directory = System::getTemporaryDirectory();
        }

        $temp = tempnam($directory, $fileName);
        if ($temp === false) {
            throw new IOException();
        }

        return new self($temp);
    }

}
