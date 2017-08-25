<?php

namespace tagadvance\gilligan\session;

class SessionSaveHandler {

    private function __construct() {}

    static function register(\SessionHandlerInterface $session_handler, $register_shutdown = true) {
        if (isset($_SESSION)) {
            trigger_error('session already started', E_USER_WARNING);
            session_write_close();
        }
        
        return session_set_save_handler($session_handler, $register_shutdown);
    }

}