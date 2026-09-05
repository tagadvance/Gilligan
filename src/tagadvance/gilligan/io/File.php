<?php

namespace tagadvance\gilligan\io;

use tagadvance\gilligan\base\System;
use tagadvance\gilligan\base\Extensions;
use tagadvance\gilligan\text\StringClass;

Extensions::getInstance()->requires('SPL');

/**
 * An SplFileInfo with the parts of java.io.File that SPL leaves out.
 * The path is never resolved on construction, so an instance may well name something that does
 * not exist.
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
     * @return boolean false when the file was already there, so it is not a failure indicator
     */
    public function touch(): bool
    {
        if (file_exists($this->fileName)) {
            return false;
        }
        return touch($this->fileName);
    }

    /**
     * @return bool false, with a warning, when the file was not there to delete
     */
    public function delete()
    {
        return unlink($this->fileName);
    }

    /**
     * Registers a shutdown function that holds this instance alive until the script ends;
     * a failure to unlink at that point surfaces as a warning and nothing more.
     */
    public function deleteOnExit()
    {
        register_shutdown_function(function () {
            $this->delete();
        });
    }

    /**
     * The parent directory read lexically out of the path, with no filesystem lookup, so a bare
     * file name yields <code>.</code> rather than the working directory.
     */
    public function getParent(): string
    {
        return dirname($this->fileName);
    }

    /**
     * {@link self::getParent()} wrapped back up as a File.
     */
    public function getParentFile(): self
    {
        $parent = $this->getParent();
        return new File($parent);
    }

    /**
     * @return bool true when the base name starts with a dot, which is a Unix convention and
     *         says nothing on Windows
     */
    public function isHidden(): bool
    {
        $baseName = basename($this->fileName);
        ;
        $fileName = new StringClass($baseName);
        return $fileName->startsWith(self::hiddenFilePrefix);
    }

    /**
     * Alias of <code>SplFileInfo::isDir</code>.
     */
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
     * Returns the size of the partition named by this path, or of its parent's partition when
     * this is not a directory.
     *
     * @return float bytes; an unreadable path makes disk_total_space() return false, which this
     *         declared type quietly turns into 0.0
     * @see http://php.net/disk_total_space
     */
    public function getTotalSpace(): float
    {
        $directory = $this->isDirectory() ? $this->fileName : $this->getParent();
        return disk_total_space($directory);
    }

    /**
     * Returns the number of unallocated bytes in the partition named by this
     * path, or of its parent's partition when this is not a directory.
     *
     * @return float|false bytes, or false when the path cannot be read; unlike
     *         {@link self::getTotalSpace()} this one has no declared return type to hide it
     * @see http://php.net/disk_free_space
     */
    public function getFreeSpace()
    {
        $directory = $this->isDirectory() ? $this->fileName : $this->getParent();
        return disk_free_space($directory);
    }

    /**
     * Creates the file immediately, so the result already exists on disk.
     *
     * @param string $fileName a name prefix, not the name — tempnam() appends randomness and
     *        uses only the first 63 characters
     * @param string|null $directory null selects the system temporary directory
     * @throws IOException when the file could not be created
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
