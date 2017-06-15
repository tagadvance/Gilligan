<?php

namespace tagadvance\gilligan\session;

define ( 'MINUTE', 60 );
define ( 'HOUR', 3600 );

// http://www.php.net/manual/en/session.configuration.php
// for debugging
// ini_set('session.gc_probability', 1);
// ini_set('session.gc_divisor', 1); // defaults to 100
// specifies the number of seconds after which data will be seen as 'garbage' and potentially cleaned up.
// ini_set('session.gc_maxlifetime', HOUR)

// $initializer = new MySQLSessionInitializer ( $pdo );
// $initializer->createTableIfNotExists();
// $initializer->createIndexIfNotExists();
// $initializer->initialize();
// session_start();

class MySQLSessionInitializer {
	
	private $pdo;
	
	function __construct(\PDO $pdo) {
		$this->pdo = $pdo;
	}
	
	function createTableIfNotExists() {
		// http://stackoverflow.com/questions/1076714/max-length-for-client-ip-address
		$sql = 'CREATE TABLE IF NOT EXISTS `sessions` (
				`session_id` varchar(40) NOT NULL,
				`data` text NOT NULL,
				`expiration` timestamp,
				`ip` varchar(45) NOT NULL,
				PRIMARY KEY  (`session_id`)
				) ENGINE=InnoDB;';
		$statement = $this->pdo->prepare ( $sql );
		return $statement->execute ();
	}
	
	function createIndexIfNotExists() {
		$sql = 'SELECT COUNT(*) AS `count` FROM (
					SHOW INDEX FROM `sessions` WHERE Key_name = "index_expiration"
				)';
		$statement = $this->pdo->prepare ( $sql );
		if ($statement->execute ()) {
			$row = $statement->fetch ( \PDO::FETCH_OBJ );
			if ($row->count == 0) {
				$sql = 'CREATE INDEX `index_expiration` ON `sessions` (`expiration`)';
				$result = $this->pdo->exec ( $sql );
			}
			$statement->closeCursor ();
		}
		return $result ?? true;
	}
	
	function initialize($register_shutdown = true) {
		if (isset ( $_SESSION )) {
			trigger_error ( 'session already started', E_USER_WARNING );
			session_write_close ();
		}
		
		$options = self::BIND_TO_IP | self::DO_NOTHING_ON_DESTROY;
		$handler = new MySQLSessionHandler ( $this->pdo, $options );
		SessionSaveHandler::register ( $handler, $register_shutdown );
	}
	
}