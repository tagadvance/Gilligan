<?php

namespace tagadvance\gilligan\session;

/**
 * Hands back a connection that was already open, so the cost is paid whether or not the session
 * is ever touched.
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
