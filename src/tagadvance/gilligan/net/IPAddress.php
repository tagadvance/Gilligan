<?php

namespace tagadvance\gilligan\net;

/**
 * A single internet address, held numerically so that subnet arithmetic is cheap.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface IPAddress
{
    /**
     * @return int the address as an integer, which on a 32-bit build is signed and so turns
     *         negative above 127.255.255.255
     */
    public function getAddressLong(): int;

    /**
     * @return string the canonical dotted-quad form, rendered back out of the integer rather
     *         than echoing what was passed in
     */
    public function getAddress(): string;

    /**
     * Is $this address in supnet $cidr?
     *
     * @param string $cidr network and prefix length, e.g. '127.0.0.1/24'; a subnet that is not
     *        aligned to its own mask is tolerated
     * @return bool true when this address falls inside that range
     */
    public function isInSubnet(string $cidr): bool;

    /**
     * @return bool true for RFC 1918 space and for loopback, which this counts as private;
     *         link-local (169.254/16) and carrier-grade NAT (100.64/10) are not covered
     * @see http://en.wikipedia.org/wiki/Private_network
     */
    public function isPrivate(): bool;

    /**
     * Gets the host name
     *
     * @return string the host name
     * @see http://php.net/manual/en/function.gethostname.php
     */
    public static function getHostName(): string;

    /**
     * Get the IP address corresponding to a given Internet host name.
     *
     * @param string $hostname
     *            The host name.
     */
    public static function getByName(string $hostname): IPAddress;

    /**
     * The address this host's own name resolves to, which on a stock Debian is whatever
     * /etc/hosts maps it to rather than an interface address.
     */
    public static function getLocalIP(): IPAddress;

}
