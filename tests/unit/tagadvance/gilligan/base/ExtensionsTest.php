<?php

namespace tagadvance\gilligan\base;

use PHPUnit\Framework\TestCase;

class ExtensionsTest extends TestCase {
	
	function testRequires() {
		$installedExtensions = [ 
				'apcu',
				'bcmath',
				'json' 
		];
		$extensions = new Extensions ( $installedExtensions );
		$extensions->requires ( 'apcu', 'bcmath', 'json' );
		$this->assertTrue ( true );
	}
	
	function testRequiresWithMissingExtensions() {
		$this->expectException(UnsupportedOperationException::class);
		
		$installedExtensions = [ ];
		$extensions = new Extensions ( $installedExtensions );
		$extensions->requires ( 'apcu', 'bcmath', 'json' );
	}
	
}