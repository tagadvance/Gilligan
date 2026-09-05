<?php

namespace tagadvance\gilligan\security;

class Hash
{
    public const ALGORITHM_MD5 = 'md5';

    public const ALGORITHM_SHA1 = 'sha1';

    public const ALGORITHM_SHA256 = 'sha256';

    public const ALGORITHM_SHA512 = 'sha512';

    private function __construct() {}

    public static function md5($value)
    {
        return hash(self::ALGORITHM_MD5, $value);
    }

    public static function sha1($value)
    {
        return hash(self::ALGORITHM_SHA1, $value);
    }

    public static function sha256($value)
    {
        return hash(self::ALGORITHM_SHA256, $value);
    }

    public static function sha512($value)
    {
        return hash(self::ALGORITHM_SHA512, $value);
    }

}
