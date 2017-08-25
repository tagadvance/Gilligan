<?php

namespace tagadvance\gilligan\session;

/**
 * This class is designed to make moving to a new session handler backward compatible.
 *
 * When retrieving session ddata, if a session doesn't exist with the current handler, it will check the next handler in the chain. Session data is persisted to each handler.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *        
 */
class CascadeSessionHandler implements \SessionHandlerInterface {

    /**
     *
     * @var array
     */
    private $sessionHandlers;

    /**
     * Session handlers should be ordered by priority.
     * Earlier elements will take precedence over later elements.
     *
     * @param \SessionHandlerInterface ...$handlers
     */
    function __construct(\SessionHandlerInterface ...$handlers) {
        if (empty($handlers)) {
            throw new \InvalidArgumentException();
        }
        $this->sessionHandlers = $handlers;
    }

    function open($save_path, $session_id) {
        foreach ($this->sessionHandlers as $handler) {
            if ($handler->open($save_path, $session_id)) {
                break;
            }
        }
    }

    function close() {
        foreach ($this->sessionHandlers as $handler) {
            $handler->close();
        }
    }

    function read($session_id) {
        foreach ($this->sessionHandlers as $handler) {
            $read = $handler->read($session_id);
            if (! empty($read)) {
                return $read;
            }
        }
        return '';
    }

    function write($session_id, $session_data) {
        $i = 0;
        $result = $this->sessionHandlers[$i ++]->write($session_id, $session_data);
        while ($i < count($this->sessionHandlers)) {
            $handler = $this->sessionHandlers[$i ++];
            $handler->write($session_id, $session_data);
        }
        return $result;
    }

    function destroy($session_id) {
        foreach ($this->sessionHandlers as $handler) {
            $handler->destroy($session_id);
        }
    }

    function gc($maxlifetime) {
        foreach ($this->sessionHandlers as $handler) {
            $handler->gc($maxlifetime);
        }
    }

}