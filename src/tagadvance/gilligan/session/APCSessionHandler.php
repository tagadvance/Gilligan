<?php

namespace tagadvance\gilligan\session;

use tagadvance\gilligan\cache\APC;

/**
 * A drop-in replacement session handler which saves data to APC.
 */
class APCSessionHandler implements \SessionHandlerInterface {
    
	/**
	 * 
	 * @var APC
	 */
	private $apc;

	function __construct(APC $apc) {
		$this->apc = $apc;
	}

	function open($savePath, $name) {
		return true;
	}

	function close() {
		return true;
	}

	function read($id) {
	    return isset($this->apc->$id) ? $this->apc->$id : '';
	}

	function write($id, $data) {
		$this->apc->$id = $data;
	}

	function destroy($id) {
		unset($this->apc->$id);
	}

	function gc($maxLifetime) {
		return true;
	}

}