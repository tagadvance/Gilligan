<?php

namespace tagadvance\gilligan\session;

/**
 * Installs a session handler, guarding against the session having already been started.
 */
class SessionSaveHandler
{
    private function __construct() {}

    /**
     * Warns and force-closes an already-started session before swapping the handler in, since
     * PHP will not accept one after session_start().
     *
     * @param bool $register_shutdown register session_write_close() as a shutdown function
     */
    public static function register(\SessionHandlerInterface $session_handler, $register_shutdown = true)
    {
        if (isset($_SESSION)) {
            trigger_error('session already started', E_USER_WARNING);
            session_write_close();
        }

        return session_set_save_handler($session_handler, $register_shutdown);
    }

}
