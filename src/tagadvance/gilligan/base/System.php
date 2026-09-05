<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\text\StringClass;
use tagadvance\gilligan\time\SystemTimeProvider;

/**
 * Java-style access to a few process- and host-level facts.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
class System
{
    /**
     * @return integer the current wall-clock time in milliseconds
     */
    public static function currentTimeMillis()
    {
        $provider = new SystemTimeProvider();
        return $provider->currentTimeMillis();
    }

    /**
     * @see http://php.net/sys_get_temp_dir
     */
    public static function getTemporaryDirectory()
    {
        return sys_get_temp_dir();
    }

    /**
     * @return float[]|false the one, five and fifteen minute load averages, or false on a
     *         platform that does not implement them
     * @see http://www.php.net/manual/en/function.sys-getloadavg.php
     */
    public static function getLoadAverage()
    {
        return sys_getloadavg();
    }

    /**
     * @return bool true only for the plain <code>cli</code> SAPI; the built-in web server
     *         reports <code>cli-server</code> and does not match
     */
    public static function isCLI()
    {
        $sapi = php_sapi_name();
        return ($sapi === 'cli'); // TODO: discourage string literals
    }

    /**
     * @return bool true for any SAPI whose name starts with <code>cgi</code>, which covers
     *         <code>cgi-fcgi</code> but not <code>fpm-fcgi</code>
     */
    public static function isCGI()
    {
        $sapi = php_sapi_name();
        return StringClass::valueOf($sapi)->startsWith('cgi');
    }

    private function __construct() {}

}
