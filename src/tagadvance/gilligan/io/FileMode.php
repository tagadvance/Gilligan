<?php

namespace tagadvance\gilligan\io;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see http://www.php.net/manual/en/function.fopen.php
 */
final class FileMode {
	
	/**
	 * Open for reading only; place the file pointer at the beginning of the file.
	 *
	 * @var string
	 */
	const READ_ONLY = 'r';
	
	/**
	 * Open for reading and writing; place the file pointer at the beginning of the file.
	 *
	 * @var string
	 */
	const READ_WRITE = 'r+';
	
	/**
	 * Open for writing only; place the file pointer at the beginning of the file and truncate the file to zero length.
	 * If the file does not exist, attempt to create it.
	 *
	 * @var string
	 */
	const WRITE_ONLY_TRUNCATE = 'w';
	
	/**
	 * Open for reading and writing; place the file pointer at the beginning of the file and truncate the file to zero length.
	 * If the file does not exist, attempt to create it.
	 *
	 * @var string
	 */
	const READ_WRITE_TRUNCATE = 'w+';
	
	/**
	 * Open for writing only; place the file pointer at the end of the file.
	 * If the file does not exist, attempt to create it.
	 *
	 * @var string
	 */
	const WRITE_ONLY_APPEND = 'a';
	
	/**
	 * Open for reading and writing; place the file pointer at the end of the file.
	 * If the file does not exist, attempt to create it.
	 *
	 * @var string
	 */
	const READ_WRITE_APPEND = 'a+';
	
	/**
	 * Create and open for writing only; place the file pointer at the beginning of the file.
	 * If the file already exists, the <code>fopen()<code> call will fail by returning <code>FALSE</code> and generating an error of level <code>E_WARNING</code>. If the file does not exist, attempt to create it. This is equivalent to specifying <code>O_EXCL|O_CREAT</code> flags for the underlying <code>open(2)</code> system call.
	 *
	 * @var string
	 */
	const WRITE_ONLY_MUST_NOT_EXIST = 'x';
	
	/**
	 * Create and open for reading and writing; otherwise it has the same behavior as 'x'.
	 *
	 * @var string
	 */
	const READ_WRITE_MUST_NOT_EXIST = 'x+';
	
	/**
	 * Open the file for writing only.
	 * If the file does not exist, it is created. If it exists, it is neither truncated (as opposed to 'w'), nor the call to this function fails (as is the case with 'x'). The file pointer is positioned on the beginning of the file. This may be useful if it's desired to get an advisory lock (see flock()) before attempting to modify the file, as using 'w' could truncate the file before the lock was obtained (if truncation is desired, ftruncate() can be used after the lock is requested).
	 *
	 * @var string
	 */
	const WRITE_ONLY_ADVISORY = 'c';
	
	/**
	 * Open the file for reading and writing; otherwise it has the same behavior as 'c'.
	 *
	 * @var string
	 */
	const READ_WRITE_ADVISORY = 'c+';
	
	/**
	 * Hidden constructor.
	 */
	private function __construct() {
	}
	
}