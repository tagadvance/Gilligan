<?php

namespace tagadvance\gilligan\crypt;

interface Crypt {
	
	function encrypt(string $data): string;
	
	function decrypt(string $data): string;
	
}