<?php

namespace tagadvance\gilligan\security;

class Hash {

    const ALGORITHM_MD5 = 'md5';

    const ALGORITHM_SHA1 = 'sha1';

    const ALGORITHM_SHA256 = 'sha256';

    const ALGORITHM_SHA512 = 'sha512';

    private function __construct() {}

    static function md5($value) {
        return hash(self::ALGORITHM_MD5, $value);
    }

    static function sha1($value) {
        return hash(self::ALGORITHM_SHA1, $value);
    }

    static function sha256($value) {
        return hash(self::ALGORITHM_SHA256, $value);
    }

    static function sha512($value) {
        return hash(self::ALGORITHM_SHA512, $value);
    }

}