<?php

namespace tagadvance\gilligan\err;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see https://google.github.io/guava/releases/21.0/api/docs/com/google/common/base/Throwables.html
 */
final class Throwables {

    private function __consruct() {}

    /**
     *
     * @param \Throwable $t
     * @return array
     */
    static function getCausalChain(\Throwable $t): array {
        $causes = [];
        while ($t) {
            $causes[] = $t;
            $t = $t->getPrevious();
        }
        return $causes;
    }

    /**
     *
     * @param \Throwable $t
     * @return \Throwable
     */
    static function getRootCause(\Throwable $t): \Throwable {
        while ($cause = $t->getPrevious()) {
            $t = $cause;
        }
        return $t;
    }

}