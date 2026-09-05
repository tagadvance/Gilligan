<?php

namespace tagadvance\gilligan\session;

/**
 * The seam that lets a session handler take a connection without deciding when it is opened.
 */
interface PDOSupplier
{
    /**
     * Called on every query, so an implementation that connects lazily should memoize.
     */
    public function getPDO(): \PDO;

}
