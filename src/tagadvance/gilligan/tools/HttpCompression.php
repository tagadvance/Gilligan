<?php

namespace tagadvance\gilligan\tools;

use tagadvance\gilligan\base\UnsupportedOperationException;

/**
 * Please note that it is generally better to rely on the compression provided by your server container.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
class HttpCompression
{
    /**
     * {@link self::initialize()} against the current request's Accept-Encoding header.
     *
     * @throws UnsupportedOperationException when the client or the build cannot do gzip
     */
    public static function initializeDefault()
    {
        $http = new self();
        $encoding = $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '';
        $http->initialize($encoding);
    }

    public function __construct() {}

    /**
     * Must run before anything is written, since it installs an output buffer and sends a header.
     * Only gzip is considered; deflate is ignored deliberately.
     *
     * @param string $encoding the client's Accept-Encoding header
     * @param int $level zlib compression level, 1 to 9
     * @throws UnsupportedOperationException when zlib is missing or the client did not offer gzip
     * @see http://stackoverflow.com/questions/1862641/compressing-content-with-php-ob-start-vs-apache-deflate-gzip
     */
    public function initialize(string $encoding, int $level = 6)
    {
        /**
         * You cannot use both ob_gzhandler() and zlib.output_compression.
         * Also note that using zlib.output_compression is preferred over ob_gzhandler().
         *
         * The zlib.output_compression test below never fires: ini_get() reports a boolean INI
         * setting as '1' or '', never 'On'.
         */
        if ((ini_get('zlib.output_compression') == 'On' || ini_get('zlib.output_compression_level') > 0) || ini_get('output_handler') == 'ob_gzhandler') {
            $message = 'using default compression';
            trigger_error($message, E_USER_WARNING);
        }

        /**
         * ignore deflate
         *
         * @see http://zoompf.com/blog/2012/02/lose-the-wait-http-compression
         */
        if (extension_loaded('zlib') && stripos($encoding, 'gzip') !== false) {
            @ini_set('zlib.output_compression_level', $level);
            /**
             * Before ob_gzhandler() actually sends compressed data, it determines what type of content encoding the browser will accept ("gzip", "deflate" or none at all) and will return its output accordingly.
             */
            if (ob_start('ob_gzhandler')) {
                header('Content-Encoding: gzip');
                return;
            }
        }

        $message = 'compression is not supported';
        throw new UnsupportedOperationException($message);
    }

}
