<?php

namespace tagadvance\gilligan\crypt;

/**
 * OpenSSL Configuration build with fluent interface.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 * @see http://php.net/manual/en/function.openssl-csr-new.php
 */
class ConfigurationBuilder {

	const CONFIG_DEBIAN = '/etc/ssl/openssl.cnf'; // debian + derivatives
	const CONFIG_RHEL = '/etc/pki/tls/openssl.cnf'; // RHEL + derivatives
	const CONFIG_WINDOWS = null; // FIXME: windows
	
	private $args;

	static function builder() {
		return new self();
	}
	
	function __construct() {
		$this->args = [];
	}

	/**
	 *
	 * @param string $filename        	
	 * @return ConfigurationBuilder
	 */
	function setConfigurationFile(string $filename): self {
		$this->args ['config'] = $filename;
		return $this;
	}

	/**
	 * Selects which digest method to use.
	 *
	 * @param string $algorithm
	 *        	e.g. 'SHA512'
	 * @return ConfigurationBuilder
	 */
	function setDigestAlgorithm(string $algorithm): self {
		$this->args ['digest_alg'] = $algorithm;
		return $this;
	}

	/**
	 * Selects which extensions should be used when creating an x509
	 * certificate.
	 *
	 * @param string $extensions
	 *        	e.g. 'v3_ca'
	 * @return ConfigurationBuilder
	 */
	function setX509Extensions(string $extensions): self{
		$this->args ['x509_extensions'] = $extensions;
		return $this;
	}

	/**
	 * Selects which extensions should be used when creating a CSR.
	 *
	 * @param string $extensions
	 *        	e.g. 'v3_req'
	 * @return ConfigurationBuilder
	 */
	function setRequiredExtensions(string $extensions): self{
		$this->args ['req_extensions'] = $extensions;
		return $this;
	}

	/**
	 * Specifies how many bits should be used to generate a private key.
	 *
	 * @param integer $bits
	 *        	e.g. 4096
	 * @return ConfigurationBuilder
	 */
	function setPrivateKeyBits(int $bits): self {
		$this->args ['private_key_bits'] = $bits;
		return $this;
	}

	/**
	 * Specifies the type of private key to create.
	 * This can be one of OPENSSL_KEYTYPE_DSA, OPENSSL_KEYTYPE_DH or
	 * OPENSSL_KEYTYPE_RSA. The default value is OPENSSL_KEYTYPE_RSA which is
	 * currently the only supported key type.
	 *
	 * @param integer $type
	 *        	e.g. OPENSSL_KEYTYPE_RSA
	 * @return ConfigurationBuilder
	 */
	function setPrivateKeyType(int $type = OPENSSL_KEYTYPE_RSA): self{
		$this->args ['private_key_type'] = $type;
		return $this;
	}
	
	// TODO: DSL e.g. [...]->encryptKey($key)->withCypher($cypher)
	
	/**
	 * Should an exported key (with passphrase) be encrypted?
	 *
	 * @param bool $b        	
	 * @return ConfigurationBuilder
	 */
	function encryptKey(bool $b = true): self {
		$this->args ['encrypt_key'] = $b;
		return $this;
	}

	/**
	 * One of <a href="http://www.php.net/manual/en/openssl.ciphers.php">cipher
	 * constants</a>.
	 *
	 * @param integer $cypher        	
	 * @return ConfigurationBuilder
	 */
	function withCypher(int $cypher): self {
		$this->args ['encrypt_key_cipher'] = $cypher;
		return $this;
	}

	function build(): array {
		return $this->args;
	}

}