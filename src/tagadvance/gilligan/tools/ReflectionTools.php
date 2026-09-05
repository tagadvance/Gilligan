<?php

namespace tagadvance\gilligan\tools;

/**
 * Converts between the two naming conventions PHP itself mixes — camelCase methods against
 * snake_case functions — which is what lets {@link FluentBuilder} accept either spelling.
 */
class ReflectionTools
{
    private function __construct() {}

    /**
     * Breaks before every capital, so digits stay attached to the word they follow and
     * base64Encode becomes base64_encode.
     */
    public static function camelCaseToUnderscore($string)
    {
        $tokens = preg_split('/(?=[A-Z])/', $string, $limit = -1, PREG_SPLIT_NO_EMPTY);
        array_walk($tokens, function (&$token) {
            $token = strtolower($token);
        });
        // digits stay attached to the word they follow, e.g. base64Encode -> base64_encode
        return implode('_', $tokens);
    }

    /**
     * @param boolean $capitaliseFirstCharacter true for StudlyCase rather than camelCase; on the
     *        empty string this raises an Error rather than returning it unchanged
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
