<?php

namespace tagadvance\gilligan\io;

use PHPUnit\Framework\TestCase;

/**
 * There isn't a whole lot to test here. Most methods are wrappers for native functions.
 */
class FileTest extends TestCase {
	
	function testIsHidden() {
		$fileName = '.foo';
		$file = File::createTemporaryFile($fileName);
		$condition = $file->isHidden();
		$this->assertTrue($condition);
	}
	
	function testGetTotalSpace() {
		$fileName = 'foo';
		$file = File::createTemporaryFile($fileName);
		$totalSpace = $file->getTotalSpace();
		$condition = $totalSpace > 0;
		$this->assertTrue($condition);
	}
	
	function testGetFreeSpace() {
		$fileName = 'foo';
		$file = File::createTemporaryFile($fileName);
		$totalSpace = $file->getFreeSpace();
		$condition = $totalSpace > 0;
		$this->assertTrue($condition);
	}
	
	function testCreateTemporaryFile() {
		$fileName = 'foo';
		$file = File::createTemporaryFile($fileName);
		$this->assertNotNull($file);
	}
	
}