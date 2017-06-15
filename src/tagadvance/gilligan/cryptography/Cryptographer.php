<?php

namespace tagadvance\gilligan\cryptography;

interface Crypt {
	
	function encrypt(string $data): string;
	
	function decrypt(string $data): string;
	
}