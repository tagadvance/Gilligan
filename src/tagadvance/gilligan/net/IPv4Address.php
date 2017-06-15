<?php

namespace tagadvance\gilligan\net;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class IPv4Address {
	
	const LOCALHOST = '127.0.0.1';
	
	private $address;
	
	/**
	 * A standard format address.
	 *
	 * @param string $address        	
	 */
	function __construct(string $address) {
		$this->address = ip2long ( $address );
	}
	
	function getAddressLong(): int {
		return $this->address;
	}
	
	function getAddress(): string {
		return long2ip($this->address);
	}
	
	/**
	 *
	 * @param string $ip e.g. '127.0.0.1'
	 * @param string $cidr e.g. '127.0.0.1/24'
	 * @return bool
	 * @see http://stackoverflow.com/a/594134/625688
	 */
	function isInSubnet(string $cidr): bool {
		list ( $subnet, $bits ) = explode ( '/', $cidr );
		$subnet = ip2long ( $subnet );
		$mask = -1 << (32 - $bits);
		$subnet &= $mask; // nb: in case the supplied subnet wasn't correctly aligned
		return ($this->address & $mask) == $subnet;
	}
	
	/**
	 *
	 * @return bool
	 * @see http://en.wikipedia.org/wiki/Private_network
	 */
	function isPrivate(): bool {
		$privateSubnets = [ 
				'10.0.0.0/8',
				'127.0.0.0/8',
				'172.16.0.0/12',
				'192.168.0.0/16' 
		];
		foreach ( $privateSubnets as $privateSubnet ) {
			if ($this->isInSubnet ( $privateSubnet )) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Gets the host name
	 *
	 * @return string
	 * @see http://php.net/manual/en/function.gethostname.php
	 */
	static function getHostName(): string {
		return gethostname ();
	}
	
	/**
	 * Get the IPv4 address corresponding to a given Internet host name
	 *
	 * @param string $hostname
	 *        	The host name.
	 * @return \tagadvance\gilligan\net\IPv4Address
	 * @throws
	 *
	 * @see http://php.net/manual/en/function.gethostbyname.php
	 */
	static function getByName($hostname): self {
		$host = gethostbyname ( $hostname );
		if ($host === $hostname) {
			throw new \InvalidArgumentException ( $hostname );
		}
		return new self ( $host );
	}
	
	/**
	 * 
	 * @return self
	 */
	static function getLocalIP(): self {
		$hostname = self::getHostName ();
		return self::getByName ( $hostname );
	}
	
}