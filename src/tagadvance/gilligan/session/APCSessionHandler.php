<?php

namespace tagadvance\gilligan\session;

/**
 * A drop-in replacement session handler which saves data to APC.
 * WARNING: APC is volatile!
 */
class APCSessionHandler implements \SessionHandlerInterface {

    const META_KEY_CREATION_TIME = 'CREATION_TIME';

    const META_KEY_EXPIRATION_TIME = 'CREATION_TIME';

    const META_KEY_REMOTE_ADDRESS = 'REMOTE_ADDRESS';

    private $prefix;

    function __construct(string $prefix = 'session_') {
        $this->prefix = $prefix;
    }

    private function createKey(string $id): string {
        return $this->prefix . $id;
    }

    function open($savePath, $name) {
        return true;
    }

    function close() {
        return true;
    }

    function read($id) {
        $key = $this->createKey($id);
        if (apc_exists($key)) {
            $entry = apc_fetch($key);
            if ($entry instanceof APCSessionEntry) {
                return $entry->getData();
            }
        }
        return '';
    }

    function write($id, $data) {
        $key = $this->createKey($id);
        if (apc_exists($key)) {
            $entry = apc_fetch($key);
            if ($entry instanceof APCSessionEntry) {
                $entry->setData($data);
            }
        } else {
            $meta = [
                    self::META_KEY_REMOTE_ADDRESS => ''
            ];
            $entry = new APCSessionEntry($id, $data, $meta);
        }
        
        $timeToLive = get_cfg_var('session.gc_maxlifetime');
        apc_store($key, $entry, $timeToLive);
    }

    function destroy($id) {
        $key = $this->createKey($id);
        apc_delete($key);
    }

    /**
     * This method doesn't do anything; instead, we rely on the TTL.
     * 
     * {@inheritdoc}
     * @see SessionHandlerInterface::gc()
     */
    function gc($maxLifetime) {
        // $lifetime = get_cfg_var('session.gc_maxlifetime');
        
        // $cache = 'user';
        // $pattern = "/^$this->prefix/";
        // foreach (new \APCIterator($cache, $pattern) as $counter) {
        //     $expirationTime = $counter['access_time'] + $lifetime;
        //     if ($expirationTime <= time()) {
        //         apc_delete($counter['key']);
        //     }
        // }
        
        return true;
    }

}