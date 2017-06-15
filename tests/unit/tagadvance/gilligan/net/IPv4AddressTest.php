<?php

namespace tagadvance\gilligan\net;

use PHPUnit\Framework\TestCase;

class IPv4AddressTest extends TestCase {
	
	function testConstructor() {
		$expected = (127 * pow($base = 256, $exponent = 3)) + 1;
		
		$ip = new IPv4Address(IPv4Address::LOCALHOST);
		$address = $ip->getAddressLong();
		
		$this->assertEquals($expected, $actual = $address);
	}
	
	/**
	 * @dataProvider validSubnetProvider
	 */
	function testIsInSubnet(string $address, string $cidr) {
		$ip = new IPv4Address ( $address );
		$condition = $ip->isInSubnet ( $cidr );
		$this->assertTrue ( $condition );
	}
	
	function validSubnetProvider() {
		return [ 
				[ 
						'192.168.0.0',
						'192.168.0.0/24' 
				],
				[ 
						'192.168.0.255',
						'192.168.0.0/24' 
				],
				[ 
						'192.168.0.8',
						'192.168.0.8/29' 
				],
				[ 
						'192.168.0.15',
						'192.168.0.8/29' 
				] 
		];
	}
	
	/**
	 * @dataProvider invalidSubnetProvider
	 */
	function testIsNotInSubnet(string $address, string $cidr) {
		$ip = new IPv4Address ( $address );
		$condition = $ip->isInSubnet ( $cidr );
		$this->assertFalse ( $condition );
	}
	
	function invalidSubnetProvider() {
		return [ 
				[ 
						'192.168.0.7',
						'192.168.0.8/29' 
				],
				[ 
						'192.168.0.18',
						'192.168.0.8/29' 
				] 
		];
	}
	
	/**
	 * @dataProvider privateAddresses
	 */
	function testIsPrivate(string $address) {
		$ip = new IPv4Address ( $address );
		$isPrivate = $ip->isPrivate();
		$this->assertTrue ( $isPrivate );
	}
	
	function privateAddresses() {
		return [ 
				[ 
						'10.0.0.0' 
				],
				[ 
						'10.255.255.255' 
				],
				[ 
						'127.0.0.0' 
				],
				[ 
						'127.255.255.255' 
				],
				[ 
						'172.16.0.0' 
				],
				[ 
						'172.31.255.255' 
				],
				[ 
						'192.168.0.0' 
				],
				[ 
						'192.168.255.255' 
				] 
		];
	}
	
	/**
	 * @dataProvider publicAddresses
	 */
	function testIsPublic(string $address) {
		$ip = new IPv4Address ( $address );
		$isPrivate = $ip->isPrivate();
		$this->assertFalse ( $isPrivate );
	}
	
	function publicAddresses() {
		return [
				[
						'9.255.255.255'
				],
				[
						'11.0.0.0'
				],
				[
						'126.255.255.255'
				],
				[
						'128.0.0.0'
				],
				[
						'172.15.255.255'
				],
				[
						'172.32.0.0'
				],
				[
						'192.167.255.255'
				],
				[
						'192.169.0.0'
				]
		];
	}
	
	function testGetByName() {
		$expected = '34.210.19.227';
		
		$hostname = 'intentionallyblankpage.com';
		$ip = IPv4Address::getByName($hostname);
		
		$this->assertEquals($expected, $actual = $ip->getAddress());
	}
	
	function testGetLocalIP() {
		IPv4Address::getLocalIP();
		$this->assertTrue(true);
	}
	
	
}