<?php

namespace tagadvance\gilligan\session;

/**
 * A drop-in replacement session handler which persists data to a MySQL database.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class MySQLSessionHandler implements \SessionHandlerInterface
{
    /**
     * Prevents a session from being hijacked by another IP address.
     */
    public const BIND_TO_IP = 1;

    /**
     * Invalidates a session instead of deleting it.
     * This is useful for debugging.
     */
    public const DO_NOTHING_ON_DESTROY = 2;

    /**
     *
     * @var boolean
     */
    private $isInitialized = false;

    /**
     *
     * @var PDOSupplier
     */
    private $pdoSupplier;

    /**
     * Remote IP address.
     *
     * @var string
     */
    private $remoteAddress;

    /**
     *
     * @var int
     */
    private $options;

    /**
     *
     * @param \PDO $pdo
     * @param string $remoteAddress
     *            Remote IP address.
     * @param int $options
     */
    public function __construct(PDOSupplier $pdoSupplier, string $remoteAddress, int $options = 0)
    {
        $this->pdoSupplier = $pdoSupplier;
        $this->remoteAddress = $remoteAddress;
        $this->options = $options;
    }

    public function initialize()
    {
        if (! $this->isInitialized) {
            $this->createTableIfNotExists();
            $this->createIndexIfNotExists();
            $this->isInitialized = true;
        }
    }

    private function createTableIfNotExists()
    {
        $pdo = $this->pdoSupplier->getPDO();
        // http://stackoverflow.com/questions/1076714/max-length-for-client-ip-address
        // https://stackoverflow.com/a/23033086/625688
        $sql = 'CREATE TABLE IF NOT EXISTS `sessions` (
				`session_id` varchar(40) NOT NULL,
				`data` text NOT NULL,
				`creation_time` timestamp NULL DEFAULT null,
				`expiration_time` timestamp NULL DEFAULT null,
				`ip` varchar(45) NOT NULL,
				PRIMARY KEY  (`session_id`)
				) ENGINE=InnoDB;';
        $statement = $pdo->prepare($sql);
        return $statement->execute();
    }

    private function createIndexIfNotExists()
    {
        $pdo = $this->pdoSupplier->getPDO();
        $sql = 'SHOW INDEX FROM `sessions` WHERE Key_name = "index_expiration";';
        $statement = $pdo->prepare($sql);
        if ($statement->execute()) {
            try {
                $row = $statement->fetch(\PDO::FETCH_OBJ);
                if ($row === false) {
                    $sql = 'CREATE INDEX `index_expiration` ON `sessions` (`expiration_time`)';
                    return $pdo->exec($sql);
                }
            } finally {
                $statement->closeCursor();
            }
        }
        return false;
    }

    public function open($savePath, $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($session_id): string|false
    {
        $this->initialize();
        $pdo = $this->pdoSupplier->getPDO();
        $sql = 'SELECT `data`, `ip` FROM `sessions` WHERE `session_id` = :session_id AND `expiration_time` > NOW()';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':session_id', $session_id);
        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_OBJ);
        $statement->closeCursor();
        if ($result !== false) {
            if ($this->isOptionSelected(self::BIND_TO_IP) && $result->ip != $this->remoteAddress) {
                $this->triggerError('this session is bound to a different ip');
            }
            return $result->data;
        }
        return '';
    }

    /**
     * Honor the PDO ATTR_ERRMODE.
     */
    private function triggerError($message)
    {
        $pdo = $this->pdoSupplier->getPDO();
        $mode = $pdo->getAttribute(\PDO::ATTR_ERRMODE);
        switch ($mode) {
            case \PDO::ERRMODE_WARNING:
                trigger_error($message, E_USER_ERROR);
                break;
            case \PDO::ERRMODE_EXCEPTION:
                throw new \RuntimeException($message);
                break;
            case \PDO::ERRMODE_SILENT:
            default:
                break;
        }
    }

    public function write($id, $data): bool
    {
        $this->initialize();
        $pdo = $this->pdoSupplier->getPDO();
        $sql = 'INSERT INTO `sessions` (`session_id`, `ip`, `data`, `creation_time`, `expiration_time`) VALUES (:session_id, :ip, :data, NULL, ADDDATE(NOW(), INTERVAL :expiration SECOND)) ON DUPLICATE KEY UPDATE `data` = VALUES (`data`), `expiration_time` = VALUES (`expiration_time`)';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':session_id', $id);
        $statement->bindValue(':ip', $this->remoteAddress);
        $statement->bindValue(':data', $data);
        $statement->bindValue(':expiration', $this->getMaxLifetime(), \PDO::PARAM_INT);
        return $statement->execute();
    }

    /**
     * The effective session lifetime in seconds.
     *
     * ini_get() rather than get_cfg_var(): get_cfg_var() reads only php.ini
     * and ignores ini_set(), so a runtime-configured lifetime was silently
     * bound as an INTERVAL of 0 SECOND, expiring every session as it was
     * written.
     */
    public function getMaxLifetime(): int
    {
        return (int) ini_get('session.gc_maxlifetime') ?: 1440;
    }

    public function destroy($id): bool
    {
        $this->initialize();
        $pdo = $this->pdoSupplier->getPDO();

        if ($this->isOptionSelected(self::DO_NOTHING_ON_DESTROY)) {
            $sql = 'UPDATE `sessions` SET `expiration_time` = NOW() WHERE `session_id` = :session_id';
            $statement = $pdo->prepare($sql);
            $statement->bindValue(':session_id', $id);
            return $statement->execute();
        }

        $sql = 'DELETE FROM `sessions` WHERE `session_id` = :session_id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':session_id', $id);
        return $statement->execute();
    }

    public function gc($maxLifetime): int|false
    {
        if ($this->isOptionSelected(self::DO_NOTHING_ON_DESTROY)) {
            return 0;
        }

        $this->initialize();
        $pdo = $this->pdoSupplier->getPDO();
        $sql = 'DELETE FROM `sessions` WHERE `expiration_time` < NOW()';
        $statement = $pdo->prepare($sql);
        if (! $statement->execute()) {
            return false;
        }

        return $statement->rowCount();
    }

    private function isOptionSelected(int $option)
    {
        return ($this->options & $option) == $option;
    }

}
