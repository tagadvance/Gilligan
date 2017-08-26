<?php

namespace tagadvance\gilligan\tools;

class ReflectionTools {

    private function __construct() {}

    /**
     *
     * @param string $string
     * @return string
     */
    static function camelCaseToUnderscore($string) {
        $tokens = preg_split('/(?=[A-Z])/', $string);
        array_walk($tokens, function (&$token) {
            $token = strtolower($token);
        });
        $string = implode('_', $tokens);
        // digits must be checked seperately to avoid matching single digits
        // http://stackoverflow.com/a/1589535/625688
        $string = preg_replace('/(\w)([0-9])/', '$1_$2', $string);
        return $string;
    }

    /**
     *
     * @param string $string
     * @param boolean $capitaliseFirstCharacter
     * @return string
     * @see https://gist.github.com/paulferrett/8141290
     */
    static function underscoreToCamelCase($string, $capitaliseFirstCharacter = false) {
        if ($capitaliseFirstCharacter) {
            $string[0] = strtoupper($string[0]);
        }
        $function = function ($string) {
            return strtoupper($string[1]);
        };
        return preg_replace_callback('/_([a-z0-9])/', $function, $string);
    }

}