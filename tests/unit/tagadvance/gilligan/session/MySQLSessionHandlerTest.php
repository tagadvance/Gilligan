<?php

namespace tagadvance\gilligan\session;

use PHPUnit\Framework\TestCase;

/**
 * These tests require a MySQL database running on localhost.
 * 
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
// CREATE DATABASE `phpunit` /*!40100 DEFAULT CHARACTER SET utf8 */;
// CREATE USER 'phpunit'@'localhost' IDENTIFIED BY 'password';
// GRANT ALL PRIVILEGES ON `phpunit`.* TO 'phpunit'@'localhost';
class MySQLSessionHandlerTest extends TestCase {

    const SESSION_ID = 'CAFEBABE';

    const REMOTE_ADDRESS = 'localhost';

    private $pdo;

    function setUp() {
        $dsn = 'mysql:host=localhost;charset=UTF8;dbname=phpunit';
        $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
        ];
        $this->pdo = new \PDO($dsn, $user = 'phpunit', $password = 'password', $options);
        
        
        // force create table and index
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        $handler->initialize();
    }

    function testReadAndWrite() {
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        
        $writeData = 'foo';
        $handler->write(self::SESSION_ID, $writeData);
        
        $readData = $handler->read(self::SESSION_ID);
        
        $this->assertEquals($expected = $writeData, $actual = $readData);
        
        /*
         * Ensure that `expiration_time` is correct
         */
        $sql = 'SELECT `session_id`, `data`, `expiration_time`, `ip` FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            
            $date = new \DateTime();
            $time = time() + get_cfg_var('session.gc_maxlifetime');
            $date->setTimestamp($time);
            $format = 'i:s';
            $expectedExpiration = $date->format($format);
            
            $sqlformat = 'Y-m-d h:i:s';
            $date = \DateTime::createFromFormat($sqlformat, $row->expiration_time);
            $actualExpiration = $date->format($format);
            
            $this->assertEquals($expectedExpiration, $actualExpiration);
        } finally {
            $statement->closeCursor();
        }
    }

    function testReadWithExpiredSession() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_SUB(NOW(), INTERVAL 1 SECOND), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        
        $readData = $handler->read(self::SESSION_ID);
        $this->assertEquals($expected = '', $actual = $readData);
    }

    /**
     * @expectedException \RuntimeException
     */
    function testReadWithBindToIp() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_ADD(NOW(), INTERVAL 1 MINUTE), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $remoteAddress = 'NOT_LOCALHOST';
        $options = MySQLSessionHandler::BIND_TO_IP;
        $handler = new MySQLSessionHandler($supplier, $remoteAddress, $options);
        
        $readData = $handler->read(self::SESSION_ID);
    }

    /**
     * Ensure consecutive writes with the same session_id overwrite previous information.
     */
    function testOverwrite() {
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        
        $handler->write(self::SESSION_ID, 'foo');
        $handler->write(self::SESSION_ID, 'bar');
        
        $sql = 'SELECT COUNT(*) AS count FROM `sessions`;';
        $statement = $this->pdo->prepare($sql);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            $this->assertEquals($expected = 1, $actual = $row->count);
        } finally {
            $statement->closeCursor();
        }
    }

    function testDestroy() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_SUB(NOW(), INTERVAL 1 SECOND), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        $handler->destroy(self::SESSION_ID);
        
        /*
         * Ensure that the session was destroyed.
         */
        $sql = 'SELECT COUNT(*) AS count FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            $this->assertEquals($expected = 0, $actual = $row->count);
        } finally {
            $statement->closeCursor();
        }
    }

    function testDestroyWithDoNothingOnDestroy() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_SUB(NOW(), INTERVAL 1 SECOND), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $options = MySQLSessionHandler::DO_NOTHING_ON_DESTROY;
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS, $options);
        $handler->destroy(self::SESSION_ID);
        
        $sql = 'SELECT COUNT(*) AS count FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            $this->assertEquals($expected = 1, $actual = $row->count);
        } finally {
            $statement->closeCursor();
        }
        
        /*
         * Ensure that the "destoryed" session is expired.
         */
        $sql = 'SELECT `session_id`, `data`, `expiration_time`, `ip` FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            
            $date = new \DateTime();
            $format = 'i:s';
            $expectedExpiration = $date->format($format);
            
            $sqlformat = 'Y-m-d h:i:s';
            $date = \DateTime::createFromFormat($sqlformat, $row->expiration_time);
            $actualExpiration = $date->format($format);
            
            $this->assertEquals($expectedExpiration, $actualExpiration);
        } finally {
            $statement->closeCursor();
        }
    }

    function testGarbageCollection() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_SUB(NOW(), INTERVAL 1 SECOND), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS);
        $handler->gc($maxLifetime = 0);
        
        /*
         * Ensure that the session was destroyed.
         */
        $sql = 'SELECT COUNT(*) AS count FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            $this->assertEquals($expected = 0, $actual = $row->count);
        } finally {
            $statement->closeCursor();
        }
    }

    function testGarbageCollectionWithDoNothingOnDestroy() {
        $sql = 'INSERT INTO `sessions` (`session_id`, `data`, `expiration_time`, `ip`) VALUES (:session_id, :data, DATE_SUB(NOW(), INTERVAL 1 SECOND), :ip);';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $statement->bindValue(':data', 'foo');
        $statement->bindValue(':ip', self::REMOTE_ADDRESS);
        $this->assertTrue($statement->execute());
        
        $supplier = new EagerPDOSupplier($this->pdo);
        $options = MySQLSessionHandler::DO_NOTHING_ON_DESTROY;
        $handler = new MySQLSessionHandler($supplier, self::REMOTE_ADDRESS, $options);
        $handler->gc(self::SESSION_ID);
        
        $sql = 'SELECT COUNT(*) AS count FROM `sessions` WHERE `session_id` = :session_id;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':session_id', self::SESSION_ID);
        $this->assertTrue($statement->execute());
        try {
            $row = $statement->fetch(\PDO::FETCH_OBJ);
            $this->assertEquals($expected = 1, $actual = $row->count);
        } finally {
            $statement->closeCursor();
        }
    }

    function tearDown() {
        $sql = 'DROP TABLE `sessions`;';
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        unset($this->pdo);
    }

}