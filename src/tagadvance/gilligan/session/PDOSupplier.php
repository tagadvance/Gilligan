<?php

namespace tagadvance\gilligan\session;

/**
 * PDO supplier.
 */
interface PDOSupplier
{
    public function getPDO(): \PDO;

}
