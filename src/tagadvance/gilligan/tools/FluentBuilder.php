<?php

namespace tagadvance\gilligan\tools;

/**
 * This class is designed as a builder with a fluent interface to simplify functions which are not otherwise chainable.
 * <code>__call()</code> has been overridden to call functions with <code>$value</code> as the first argument.
 * <code>__invoke()</code> has been overriden to return <code>$value</code>.
 * <code>
 * $oneThirdFloored = FluentBuilder::valueOf(1/3)->floor();
 * $isPiInfinite = FluentBuilder::pi()->isInfinite();
 * $alphabet = FluentBuilder::valueOf('abcdef')->substr($start =
 * 3)->strtoupper();
 * </code>
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class FluentBuilder {

    private $value;

    static function valueOf($value) {
        return new FluentBuilder($value);
    }

    function __construct($value) {
        $this->value = $value;
    }

    /**
     * TODO: handle special circumstances, e.g. str_replace and preg_replace, where parameters are out of order.
     * @param string $name
     * @param array $arguments
     * @throws \BadMethodCallException
     * @return self
     */
    function __call($name, array $arguments): self {
        if (function_exists($name)) {
            array_unshift($arguments, $this->value);
            $result = call_user_func_array($name, $arguments);
            return new FluentBuilder($result);
        } else {
            $function = ReflectionTools::camelCaseToUnderscore($name);
            if (function_exists($function)) {
                array_unshift($arguments, $this->value);
                $result = call_user_func_array($function, $arguments);
                return new FluentBuilder($result);
            }
        }
        throw new \BadMethodCallException($name);
    }

    /**
     * 
     * @param unknown $name
     * @param array $arguments
     * @throws \BadMethodCallException
     * @return self
     */
    static function __callStatic($name, array $arguments): self {
        if (function_exists($name)) {
            $result = call_user_func_array($name, $arguments);
            return new FluentBuilder($result);
        } else {
            $function = ReflectionTools::camelCaseToUnderscore($name);
            if (function_exists($function)) {
                $result = call_user_func_array($function, $arguments);
                return new FluentBuilder($result);
            }
        }
        throw new \BadMethodCallException($name);
    }

    function __invoke() {
        return $this->value;
    }

}