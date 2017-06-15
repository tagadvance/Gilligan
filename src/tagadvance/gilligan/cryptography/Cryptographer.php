<?php

namespace tagadvance\gilligan\cryptography;

interface Cryptographer {
	
	function encrypt(string $data): string;
	
	function decrypt(string $data): string;
	
}