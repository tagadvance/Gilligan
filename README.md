[![Build Status](https://travis-ci.org/tagadvance/Gilligan.svg?branch=master)](https://travis-ci.org/tagadvance/Gilligan)
[![Coverage Status](https://coveralls.io/repos/github/tagadvance/Gilligan/badge.svg?branch=master)](https://coveralls.io/github/tagadvance/Gilligan?branch=master)

# Gilligan

Gilligan is a collection of PHP utilities I have created or gathered over the course of my career.

Some of these components are or were "pet projects" that I worked on simply because I thought they would be fun to implement.

The design of some of these tools was heavily influenced by libraries like [Apache Commons](https://commons.apache.org/) and [Guava](https://github.com/google/guava).

## Download / Install
The easiest way to install Gilligan is via Composer:
```bash
composer require "tagadvance/gilligan:dev-master"
```
```json
{
    "require": {
        "tagadvance/gilligan": "dev-master"
    }
}
```

## Highlights
Standard Print Streams, e.g.
```php
Standard::output()->printLine('foo');
// prints 'foo'
```

Java-like IO Streams, e.g.
```php
$fileName = 'test.php';
$file = new File( $fileName );
$stream = new FileInputStream( $file );
$bytes = $stream->read($length = 5);
Standard::output()->printLine($bytes);
// prints '<?php'
```

Backward Compatible Session Handlers, e.g.
```php
$defaultHandler = new \SessionHandler();
$pdo = new \PDO($dsn);
$supplier = new EagerPDOSupplier($pdo);
$mysqlHandler = new MySQLSessionHandler($supplier, $remoteAddress = 'localhost');
$cascadeHandler = new CascadeSessionHandler($mysqlHandler, $defaultHandler);
SessionSaveHandler::register($cascadeHandler);
session_start();
```

`StringClass`, e.g.
```php
$true = StringClass::valueOf('abcxyz')->startsWith('abc');
```