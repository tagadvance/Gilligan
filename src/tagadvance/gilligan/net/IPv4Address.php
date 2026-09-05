<?php

namespace tagadvance\gilligan\net;

/**
 * An IPv4 address held as the integer ip2long() produces.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class IPv4Address implements IPAddress
{
    public const LOCALHOST = '127.0.0.1';

    private $address;

    /**
     * Malformed input is not rejected: ip2long() returns false, which is stored as 0, so
     * '999.999.999.999' and '127.1' both become the address 0.0.0.0.
     *
     * @param string $address dotted quad; shorthand forms are not accepted
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
     * @param string $cidr
     *            e.g. '127.0.0.1/24'; the prefix length is not validated, and a $cidr with no
     *            slash at all warns and then matches nothing useful
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
     * @return bool true for 10/8, 127/8, 172.16/12 and 192.168/16; note that loopback counts
     *         as private and that link-local and carrier-grade NAT do not
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
     * @return string the empty string when the host name cannot be determined
     * @see http://php.net/manual/en/function.gethostname.php
     */
    public static function getHostName(): string
    {
        return gethostname();
    }

    /**
     * Get the IPv4 address corresponding to a given Internet host name.
     *
     * Failure is detected by gethostbyname() handing the argument straight back, so an address
     * literal is rejected too — this takes names only.
     *
     * @param string $hostname
     *            The host name.
     * @throws \InvalidArgumentException when the name does not resolve
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
     * Resolves this host's own name, so it inherits every failure mode of
     * {@link self::getByName()}.
     *
     * @throws \InvalidArgumentException when the host name does not resolve
     */
    public static function getLocalIP(): IPAddress
    {
        $hostname = self::getHostName();
        return self::getByName($hostname);
    }

}
