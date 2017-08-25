<?php

namespace tagadvance\gilligan\session;

/**
 * PDO supplier.
 */
interface PDOSupplier {

    function getPDO(): \PDO;

}