<?php

namespace tagadvance\gilligan\session;

/**
 * PDO supplier.
 */
class EagerPDOSupplier implements PDOSupplier {

    /**
     *
     * @var \PDO
     */
    private $pdo;

    function __construct(\PDO $pdo) {
        $this->pdo = $pdo;
    }

    function getPDO(): \PDO {
        return $this->pdo;
    }

}