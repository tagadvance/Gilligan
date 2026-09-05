<?php

namespace tagadvance\gilligan\tools;

class ReflectionTools
{
    private function __construct() {}

    /**
     *
     * @param string $string
     * @return string
     */
    public static function camelCaseToUnderscore($string)
    {
        $tokens = preg_split('/(?=[A-Z])/', $string);
        array_walk($tokens, function (&$token) {
            $token = strtolower($token);
        });
        // digits stay attached to the word they follow, e.g. base64Encode -> base64_encode
        return implode('_', $tokens);
    }

    /**
     *
     * @param string $string
     * @param boolean $capitaliseFirstCharacter
     * @return string
     * @see https://gist.github.com/paulferrett/8141290
     */
    public static function underscoreToCamelCase($string, $capitaliseFirstCharacter = false)
    {
        if ($capitaliseFirstCharacter) {
            $string[0] = strtoupper($string[0]);
        }
        $function = function ($string) {
            return strtoupper($string[1]);
        };
        return preg_replace_callback('/_([a-z0-9])/', $function, $string);
    }

}
