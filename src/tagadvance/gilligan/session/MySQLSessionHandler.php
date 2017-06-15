<?php

namespace tagadvance\gilligan\session;

/**
 * A drop-in replacement session handler which persists data to a MySQL database.
 */
class MySQLSessionHandler implements \SessionHandlerInterface {

	/**
	 * Prevents a session from being hijacked by another IP address.
	 */
	const BIND_TO_IP = 1;

	/**
	 * Invalidates a session instead of deleting it.
	 * This is useful for debugging.
	 */
	const DO_NOTHING_ON_DESTROY = 2;

	private $pdo;

	private $options;

	function __construct(PDO $pdo, int $options = 0) {
		$this->pdo = $pdo;
		$this->options = $options;
	}

	function __destruct() {
		unset ( $this->pdo, $this->options);
	}

	function open($savePath, $name) {
		return true;
	}

	function close() {
		return true;
	}

	function read($session_id) {
		$sql = 'SELECT `data`, `ip` FROM `sessions` WHERE `session_id` = :session_id AND `expiration` > NOW()';
		$statement = $this->pdo->prepare ( $sql );
		$statement->bindParam ( ':session_id', $session_id );
		$statement->execute ();
		$result = $statement->fetch ( PDO::FETCH_OBJ );
		$statement->closeCursor ();
		if ($result !== false) {
			$ip = get_remote_ip ();
			if ($this->isOptionSelected ( self::BIND_TO_IP ) && $result->ip != $ip) {
				$this->triggerError ( 'this session is bound to a different ip' );
			}
			return $result->data;
		}
		return '';
	}

	/**
	 * Honor the PDO ATTR_ERRMODE.
	 */
	private function triggerError($message) {
		$mode = $this->pdo->getAttribute ( PDO::ATTR_ERRMODE );
		switch ($mode) {
			case PDO::ERRMODE_WARNING :
				trigger_error ( $message, E_USER_ERROR );
				break;
			case PDO::ERRMODE_EXCEPTION :
				throw new \RuntimeException ( $message );
				break;
			case PDO::ERRMODE_SILENT :
			default :
				break;
		}
	}

	function write($id, $data) {
		$sql = 'INSERT INTO `sessions` (`session_id`, `ip`, `data`, `expiration`) VALUES (:session_id, :ip, :data, ADDDATE(NOW(), INTERVAL :expiration SECOND)) ON DUPLICATE KEY UPDATE `data` = VALUES (`data`), `expiration` = VALUES (`expiration`)';
		$statement = $this->pdo->prepare ( $sql );
		$statement->bindParam ( ':session_id', $id );
		$ip = get_remote_ip ();
		$statement->bindParam ( ':ip', $ip );
		$statement->bindParam ( ':data', $data );
		$expiration = get_cfg_var ( "session.gc_maxlifetime" );
		$statement->bindParam ( ':expiration', $expiration );
		return $statement->execute ();
	}

	function destroy($id) {
		if ($this->isOptionSelected ( self::DO_NOTHING_ON_DESTROY )) {
			$sql = 'UPDATE `sessions` SET `expiration` = NOW() WHERE `session_id` = :session_id';
			$statement = $this->pdo->prepare ( $sql );
			$statement->bindParam ( ':session_id', $id );
			return $statement->execute ();
		}
		
		$sql = 'DELETE FROM `sessions` WHERE `session_id` = :session_id';
		$statement = $this->pdo->prepare ( $sql );
		$statement->bindParam ( ':session_id', $id );
		return $statement->execute ();
	}

	function gc($maxLifetime) {
		if ($this->isOptionSelected ( self::DO_NOTHING_ON_DESTROY )) {
			return true;
		}
		
		$sql = 'DELETE FROM `sessions` WHERE `expiration` < NOW()';
		$statement = $this->pdo->prepare ( $sql );
		return $statement->execute ();
	}

	private function isOptionSelected(int $option) {
		return ($this->options & $option) == $option;
	}

}