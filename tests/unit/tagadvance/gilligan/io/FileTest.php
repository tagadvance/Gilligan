<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

/**
 * There isn't a whole lot to test here. Most methods are wrappers for native functions.
 */
class FileTest extends TestCase
{
    public function testIsHidden()
    {
        $fileName = '.foo';
        $file = File::createTemporaryFile($fileName);
        $condition = $file->isHidden();
        $this->assertTrue($condition);
    }

    public function testGetTotalSpace()
    {
        $fileName = 'foo';
        $file = File::createTemporaryFile($fileName);
        $totalSpace = $file->getTotalSpace();
        $condition = $totalSpace > 0;
        $this->assertTrue($condition);
    }

    public function testGetFreeSpace()
    {
        $fileName = 'foo';
        $file = File::createTemporaryFile($fileName);
        $totalSpace = $file->getFreeSpace();
        $condition = $totalSpace > 0;
        $this->assertTrue($condition);
    }

    public function testCreateTemporaryFile()
    {
        $fileName = 'foo';
        $file = File::createTemporaryFile($fileName);
        $this->assertNotNull($file);
    }

    public function testTouchCreatesFile()
    {
        $path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'gilligan_touch_' . uniqid();
        $file = new File($path);
        try {
            $this->assertTrue($file->touch());
            $this->assertFileExists($path);
        } finally {
            @unlink($path);
        }
    }

    public function testTouchReturnsFalseWhenFileExists()
    {
        $file = File::createTemporaryFile('gilligan_touch');
        try {
            $this->assertFalse($file->touch());
        } finally {
            @unlink($file->getPathname());
        }
    }

}
