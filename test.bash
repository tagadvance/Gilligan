#!/bin/bash

/usr/bin/php --define apc.enable_cli=1 vendor/bin/phpunit --bootstrap vendor/autoload.php  --coverage-clover /tmp/coverage.xml tests
