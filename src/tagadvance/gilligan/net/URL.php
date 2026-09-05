<?php

namespace tagadvance\gilligan\net;

use tagadvance\gilligan\base\MetaServer;

/**
 * Reassembles the absolute URL of the current request.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class URL
{
    private function __construct() {}

    /**
     * Built from the Host header and the request URI, both of which the client controls, so do
     * not use the result in a security decision or as a redirect target.
     * The port is omitted when it is the default for the scheme.
     */
    public static function getRequestURL(MetaServer $server): string
    {
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
