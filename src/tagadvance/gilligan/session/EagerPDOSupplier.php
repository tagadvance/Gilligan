<?php

namespace tagadvance\gilligan\session;

/**
 * PDO supplier.
 */
class EagerPDOSupplier implements PDOSupplier
{
    /**
     *
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getPDO(): \PDO
    {
        return $this->pdo;
    }

}
