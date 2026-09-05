<?php

namespace tagadvance\gilligan\tools;

use tagadvance\gilligan\text\StringClass;
use tagadvance\gilligan\base\Blank;

/**
 * This class is designed as a builder with a fluent interface to simplify the invocation of functions which are not otherwise chainable.
 * <code>__call()</code> has been overridden to call functions with <code>$value</code> as the first argument.
 * <code>__invoke()</code> has been overriden to return <code>$value</code>.
 * The <code>explicit</code> prefix is honoured by <code>__call()</code> only, never by
 * <code>__callStatic()</code>.
 * <code>
 * $float = FluentBuilder::valueOf(5)->explicitBcdiv(Blank::getInstance(), 3, $scale = 2);
 * $oneThirdFloored = FluentBuilder::valueOf(1/3)->floor();
 * $isPiInfinite = FluentBuilder::pi()->isInfinite();
 * $alphabet = FluentBuilder::valueOf('abcdef')->substr($start =
 * 3)->strtoupper();
 *
 * </code>
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class FluentBuilder
{
    public const EXPLICIT_PREFIX = 'explicit';

    private $value;

    public static function valueOf($value)
    {
        return new FluentBuilder($value);
    }

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Prefixing the name with <code>explicit</code> stops the value being prepended and instead
     * substitutes it for whichever argument is a {@link Blank}.
     *
     * @throws \BadMethodCallException when no function exists under that name or its
     *         snake_case form
     */
    public function __call($name, array $arguments): self
    {
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
     * The chain's starting point: it calls the function with exactly the arguments given, since
     * there is no value yet to prepend.
     *
     * The <code>explicit</code> prefix substitutes the wrapped value for a {@link Blank}
     * argument, and there is no wrapped value here, so it is rejected rather than silently
     * behaving as though the prefix were absent.
     *
     * @throws \BadMethodCallException when the name carries the <code>explicit</code> prefix,
     *         or when no function exists under that name or its snake_case form
     */
    public static function __callStatic($name, array $arguments): self
    {
        if (StringClass::valueOf($name)->startsWith(self::EXPLICIT_PREFIX)) {
            throw new \BadMethodCallException('the explicit prefix is only honoured on an instance');
        }

        if (! function_exists($name)) {
            $name = ReflectionTools::camelCaseToUnderscore($name);
            if (! function_exists($name)) {
                throw new \BadMethodCallException($name);
            }
        }

        $result = call_user_func_array($name, $arguments);
        return new FluentBuilder($result);
    }

    /**
     * Ends the chain, handing back the wrapped value.
     */
    public function __invoke()
    {
        return $this->value;
    }

}
