<?php

namespace tagadvance\gilligan\tools;

use tagadvance\gilligan\text\StringClass;
use tagadvance\gilligan\base\Blank;

/**
 * This class is designed as a builder with a fluent interface to simplify the invocation of functions which are not otherwise chainable.
 * <code>__call()</code> has been overridden to call functions with <code>$value</code> as the first argument.
 * <code>__invoke()</code> has been overriden to return <code>$value</code>.
 * <code>
 * $float = FluentBuilder::explicitBcdiv(5, 3, $scale = 2);
 * $oneThirdFloored = FluentBuilder::valueOf(1/3)->floor();
 * $isPiInfinite = FluentBuilder::pi()->isInfinite();
 * $alphabet = FluentBuilder::valueOf('abcdef')->substr($start =
 * 3)->strtoupper();
 *
 * </code>
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class FluentBuilder {

    const EXPLICIT_PREFIX = 'explicit';

    private $value;

    static function valueOf($value) {
        return new FluentBuilder($value);
    }

    function __construct($value) {
        $this->value = $value;
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws \BadMethodCallException
     * @return self
     */
    function __call($name, array $arguments): self {
        $isExplicit = StringClass::valueOf($name)->startsWith(self::EXPLICIT_PREFIX);
        if ($isExplicit) {
            $name = substr($name, $start = strlen(self::EXPLICIT_PREFIX));
            $name[0] = strtolower($name[0]);
            $arguments = array_map(function ($e) {
                return $e instanceof Blank ? $this->value : $e;
            }, $arguments);
        }
        
        if (! function_exists($name)) {
            $name = ReflectionTools::camelCaseToUnderscore($name);
            if (! function_exists($name)) {
                throw new \BadMethodCallException($name);
            }
        }
        
        if (! $isExplicit) {
            array_unshift($arguments, $this->value);
        }
        $result = call_user_func_array($name, $arguments);
        return new FluentBuilder($result);
    }

    /**
     *
     * @param string $name
     * @param array $arguments
     * @throws \BadMethodCallException
     * @return self
     */
    static function __callStatic($name, array $arguments): self {
        if (! function_exists($name)) {
            $name = ReflectionTools::camelCaseToUnderscore($name);
            if (! function_exists($name)) {
                throw new \BadMethodCallException($name);
            }
        }
        
        $result = call_user_func_array($name, $arguments);
        return new FluentBuilder($result);
    }

    function __invoke() {
        return $this->value;
    }

}
