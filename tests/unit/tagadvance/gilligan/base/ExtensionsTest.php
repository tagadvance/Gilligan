<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class ExtensionsTest extends TestCase {
	
	function testRequires() {
		$installedExtensions = [ 
				'apc',
				'bcmath',
				'json' 
		];
		$extensions = new Extensions ( $installedExtensions );
		$extensions->requires ( 'apc', 'bcmath', 'json' );
		$this->assertTrue ( true );
	}
	
	function testRequiresWithMissingExtensions() {
		$this->expectException(UnsupportedOperationException::class);
		
		$installedExtensions = [ ];
		$extensions = new Extensions ( $installedExtensions );
		$extensions->requires ( 'apc', 'bcmath', 'json' );
	}
	
}