<?php

namespace tagadvance\gilligan\net;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
interface IPAddress {

    function getAddressLong(): int;

    function getAddress(): string;

    /**
     * Is $this address in supnet $cidr?
     *
     * @param string $ip
     * @param string $cidr
     * @return bool
     */
    function isInSubnet(string $cidr): bool;

    /**
     *
     * @return bool
     * @see http://en.wikipedia.org/wiki/Private_network
     */
    function isPrivate(): bool;

    /**
     * Gets the host name
     *
     * @return string the host name
     * @see http://php.net/manual/en/function.gethostname.php
     */
    static function getHostName(): string;

    /**
     * Get the IP address corresponding to a given Internet host name.
     *
     * @param string $hostname
     *            The host name.
     * @return self
     */
    static function getByName(string $hostname): IPAddress;

    /**
     *
     * @return self
     */
    static function getLocalIP(): IPAddress;

}