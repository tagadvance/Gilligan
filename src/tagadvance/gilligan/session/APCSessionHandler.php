<?php

namespace tagadvance\gilligan\session;

use tagadvance\gilligan\cache\APC;

/**
 * A drop-in replacement session handler which saves data to APC.
 * WARNING: APC is volatile!
 */
class APCSessionHandler implements \SessionHandlerInterface {

    const META_KEY_CREATION_TIME = 'CREATION_TIME';

    const META_KEY_EXPIRATION_TIME = 'CREATION_TIME';

    const META_KEY_REMOTE_ADDRESS = 'REMOTE_ADDRESS';

    /**
     *
     * @var APC
     */
    private $apc;

    private $prefix;

    function __construct(APC $apc, string $prefix = 'session_') {
        $this->apc = $apc;
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
        if (isset($this->apc->$key)) {
            $entry = $this->apc->$key;
            if ($entry instanceof APCSessionEntry) {
                return $entry->getData();
            }
        }
        return '';
    }

    function write($id, $data) {
        $key = $this->createKey($id);
        if (isset($this->apc->$key)) {
            $entry = $this->apc->$key;
            if ($entry instanceof APCSessionEntry) {
                $entry->setData($data);
            }
        } else {
            $meta = [
                    self::META_KEY_REMOTE_ADDRESS => ''
            ];
            $entry = new APCSessionEntry($id, $data, $meta);
        }
        
        $this->apc->$key = $entry;
    }

    function destroy($id) {
        $key = $this->createKey($id);
        unset($this->apc->$key);
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
        //         $key = $counter['key'];
        //         unset($apc->$key);
        //     }
        // }
        
        return true;
    }

}