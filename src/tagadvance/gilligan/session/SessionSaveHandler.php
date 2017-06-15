<?php

namespace tagadvance\gilligan\session;

class SessionSaveHandler {

	private function __construct() {
	}
	
	static function register(\SessionHandlerInterface $session_handler, $register_shutdown = true) {
		return session_set_save_handler ( $session_handler, $register_shutdown );
	}

}