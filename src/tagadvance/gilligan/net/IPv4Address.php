<?php

namespace tagadvance\gilligan\net;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class IPv4Address implements IPAddress
{
    public const LOCALHOST = '127.0.0.1';

    private $address;

    /**
     * A standard format address.
     *
     * @param string $address
     */
    public function __construct(string $address)
    {
        $this->address = ip2long($address);
    }

    public function getAddressLong(): int
    {
        return $this->address;
    }

    public function getAddress(): string
    {
        return long2ip($this->address);
    }

    /**
     * Is $this address in supnet $cidr?
     *
     * @param string $ip
     *            e.g. '127.0.0.1'
     * @param string $cidr
     *            e.g. '127.0.0.1/24'
     * @return bool
     * @see http://stackoverflow.com/a/594134/625688
     */
    public function isInSubnet(string $cidr): bool
    {
        list($subnet, $bits) = explode('/', $cidr);
        $subnet = ip2long($subnet);
        $mask = - 1 << (32 - $bits);
        $subnet &= $mask; // nb: in case the supplied subnet wasn't correctly aligned
        return ($this->address & $mask) == $subnet;
    }

    /**
     *
     * @return bool
     * @see http://en.wikipedia.org/wiki/Private_network
     */
    public function isPrivate(): bool
    {
        $privateSubnets = [
            '10.0.0.0/8',
            '127.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
        ];
        foreach ($privateSubnets as $privateSubnet) {
            if ($this->isInSubnet($privateSubnet)) {
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
    public static function getHostName(): string
    {
        return gethostname();
    }

    /**
     * Get the IPv4 address corresponding to a given Internet host name.
     *
     * @param string $hostname
     *            The host name.
     * @throws \InvalidArgumentException
     * @return self
     * @see http://php.net/manual/en/function.gethostbyname.php
     */
    public static function getByName(string $hostname): IPAddress
    {
        $host = gethostbyname($hostname);
        if ($host === $hostname) {
            throw new \InvalidArgumentException($hostname);
        }
        return new self($host);
    }

    /**
     *
     * @return self
     */
    public static function getLocalIP(): IPAddress
    {
        $hostname = self::getHostName();
        return self::getByName($hostname);
    }

}
