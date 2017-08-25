<?php

namespace tagadvance\gilligan\net;

use tagadvance\gilligan\base\MetaServer;

/**
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class URL {
	
	private function __construct() {}

    /**
     *
     * @return string
     * @see http://php.net/parse_url
     */
    static function getRequestURL(MetaServer $server): string {
        // if (! System::isCGI()) {
        // throw new UnsupportedOperationException();
        // }
        
        $isHttps = $server->https();
        $url = $isHttps ? 'https://' : 'http://';
        $url .= $server->httpHost();
        if ((! $isHttps && $server->serverPort() != 80) || ($isHttps && $server->serverPort() != 443)) {
            $url .= ':' . $server->serverPort();
        }
        $url .= $server->requestURI();
        return $url;
    }
	
}