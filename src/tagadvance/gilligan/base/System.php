<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\text\StringClass;
use tagadvance\gilligan\time\SystemTimeProvider;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
class System
{
    /**
     *
     * @return integer Returns the current time in milliseconds.
     */
    public static function currentTimeMillis()
    {
        $provider = new SystemTimeProvider();
        return $provider->currentTimeMillis();
    }

    /**
     *
     * @return string
     * @see http://php.net/sys_get_temp_dir
     */
    public static function getTemporaryDirectory()
    {
        return sys_get_temp_dir();
    }

    /**
     *
     * @return array
     * @see http://www.php.net/manual/en/function.sys-getloadavg.php
     */
    public static function getLoadAverage()
    {
        return sys_getloadavg();
    }

    public static function isCLI()
    {
        $sapi = php_sapi_name();
        return ($sapi === 'cli'); // TODO: discourage string literals
    }

    public static function isCGI()
    {
        $sapi = php_sapi_name();
        return StringClass::valueOf($sapi)->startsWith('cgi');
    }

    private function __construct() {}

}
