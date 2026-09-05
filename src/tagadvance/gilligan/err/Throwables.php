<?php

namespace tagadvance\gilligan\err;

/**
 * Walks the chain of causes hanging off a throwable, after Guava's class of the same name.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see https://google.github.io/guava/releases/21.0/api/docs/com/google/common/base/Throwables.html
 */
final class Throwables
{
    private function __construct() {}

    /**
     * @return \Throwable[] <code>$t</code> followed by each of its causes, outermost first;
     *         never empty
     */
    public static function getCausalChain(\Throwable $t): array
    {
        $causes = [];
        while ($t) {
            $causes[] = $t;
            $t = $t->getPrevious();
        }
        return $causes;
    }

    /**
     * @return \Throwable the innermost cause, or <code>$t</code> itself when it has none
     */
    public static function getRootCause(\Throwable $t): \Throwable
    {
        while ($cause = $t->getPrevious()) {
            $t = $cause;
        }
        return $t;
    }

}
