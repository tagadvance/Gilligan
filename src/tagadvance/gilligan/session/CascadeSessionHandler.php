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
class CascadeSessionHandler implements \SessionHandlerInterface
{
    /**
     *
     * @var array
     */
    private $sessionHandlers;

    /**
     * Session handlers should be ordered by priority.
     * Earlier elements will take precedence over later elements.
     *
     * @param \SessionHandlerInterface ...$handlers at least one, ordered most preferred first
     * @throws \InvalidArgumentException when no handler is given
     */
    public function __construct(\SessionHandlerInterface ...$handlers)
    {
        if (empty($handlers)) {
            throw new \InvalidArgumentException();
        }
        $this->sessionHandlers = $handlers;
    }

    /**
     * Stops at the first handler that opens, so the rest are never opened at all — unlike every
     * other method here, which visits all of them.
     */
    public function open($save_path, $session_id): bool
    {
        foreach ($this->sessionHandlers as $handler) {
            if ($handler->open($save_path, $session_id)) {
                return true;
            }
        }

        return false;
    }

    public function close(): bool
    {
        $isClosed = true;
        foreach ($this->sessionHandlers as $handler) {
            $isClosed = $handler->close() && $isClosed;
        }

        return $isClosed;
    }

    /**
     * Returns the first handler's stored data, skipping any handler that has none or that
     * failed.
     *
     * An empty string cannot be told apart from a miss: SessionHandlerInterface specifies
     * '' as the return for a session with no data, and the handlers here return it for a
     * key that is absent, so the search continues past it either way.
     */
    public function read($session_id): string|false
    {
        foreach ($this->sessionHandlers as $handler) {
            $read = $handler->read($session_id);
            if ($read !== false && $read !== '') {
                return $read;
            }
        }
        return '';
    }

    /**
     * Writes to every handler but reports only the first one's result, so a failure further down
     * the chain is not visible to the caller.
     */
    public function write($session_id, $session_data): bool
    {
        $i = 0;
        $result = $this->sessionHandlers[$i++]->write($session_id, $session_data);
        while ($i < count($this->sessionHandlers)) {
            $handler = $this->sessionHandlers[$i++];
            $handler->write($session_id, $session_data);
        }
        return $result;
    }

    public function destroy($session_id): bool
    {
        $isDestroyed = true;
        foreach ($this->sessionHandlers as $handler) {
            $isDestroyed = $handler->destroy($session_id) && $isDestroyed;
        }

        return $isDestroyed;
    }

    /**
     * @return int|false the total collected; a handler that reports false counts as zero, so a
     *         failed collection is indistinguishable from an empty one
     */
    public function gc($maxlifetime): int|false
    {
        $total = 0;
        foreach ($this->sessionHandlers as $handler) {
            $deleted = $handler->gc($maxlifetime);
            if ($deleted !== false) {
                $total += $deleted;
            }
        }

        return $total;
    }

}
