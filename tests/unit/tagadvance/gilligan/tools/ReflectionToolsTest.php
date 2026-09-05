<?php

namespace tagadvance\gilligan\tools;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ReflectionToolsTest extends TestCase
{
    #[DataProvider('camelCaseNames')]
    public function testCamelCaseToUnderscore(string $camelCase, string $expected)
    {
        $actual = ReflectionTools::camelCaseToUnderscore($camelCase);
        $this->assertEquals($expected, $actual);
    }

    public static function camelCaseNames()
    {
        return [
            ['strToUpper', 'str_to_upper'],
            ['htmlSpecialChars', 'html_special_chars'],
            ['base64Encode', 'base64_encode'],
            ['md5', 'md5'],
            ['sha1', 'sha1'],
            ['utf8Encode', 'utf8_encode'],
        ];
    }

    #[DataProvider('camelCaseNames')]
    public function testUnderscoreToCamelCase(string $expected, string $underscored)
    {
        $actual = ReflectionTools::underscoreToCamelCase($underscored);
        $this->assertEquals($expected, $actual);
    }

}
