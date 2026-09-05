<?php

namespace tagadvance\gilligan\base;

/**
 * Supplies the key under which {@link \tagadvance\gilligan\collections\HashArray} files a
 * value, for objects that should be treated as equal without being identical.
 */
interface Hashable
{
    /**
     * @return int|string used verbatim as an array key, so two values that must collide have
     *         to return the same thing
     */
    public function hashCode();

}
