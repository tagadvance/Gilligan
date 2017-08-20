<?php

namespace tagadvance\gilligan\base;

/**
 * The idea behind <code>Extensions</code> is to fail fast.
 * Instead of receiving a vague error about a missing function half way through the execution of a script, it will throw an {@link UnsupportedOperationException} with an easy to read error message.
 * Example usage:
 *
 * <code>
 * namespace foo;
 *
 * Extensions::getInstance ()->requires ( 'Core' );
 *
 * class Bar {
 * </code>
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 */
final class Extensions {

    /**
     *
     * @var array
     */
    private $installedExtensions;

    /**
     *
     * @param array $installedExtensions
     * @see http://php.net/get_loaded_extensions
     */
    function __construct(array $installedExtensions) {
        $this->installedExtensions = $installedExtensions;
    }

    /**
     * Check for required extensions.
     *
     * e.g. 'Core', 'date', 'ereg', 'libxml', 'openssl', 'pcre', 'zlib', 'bcmath', 'bz2', 'calendar', 'ctype', 'dba', 'dom', 'hash', 'fileinfo', 'filter', 'ftp', 'gettext', 'SPL', 'iconv', 'json', 'mbstring', 'apc', 'posix', 'Reflection', 'session', 'shmop', 'SimpleXML', 'soap', 'sockets', 'standard', 'exif', 'sysvmsg', 'sysvsem', 'sysvshm', 'tokenizer', 'wddx', 'xml', 'xmlreader', 'xmlwriter', 'zip', 'apache2handler', 'PDO', 'Phar', 'curl', 'gd', 'intl', 'mysql', 'mysqli', 'pdo_mysql', 'mcrypt', 'mhash', 'xdebug'.
     *
     * @param string ...$extensions
     *            extensions which must be installed to proceed
     * @throws UnsupportedOperationException if one or more of the extensions are missing
     */
    function requires(string ...$extensions) {
        $missingExtensions = [];
        foreach ($extensions as $extension) {
            if (! in_array($extension, $this->installedExtensions)) {
                $missingExtensions[] = $extension;
            }
        }
        if (! empty($missingExtensions)) {
            $list = implode($delimiter = ', ', $missingExtensions);
            $message = "Please install the following extensions: $list";
            throw new UnsupportedOperationException($message);
        }
    }

    /**
     *
     * @return self
     */
    static function getInstance(): self {
        static $instance = null;
        if ($instance === null) {
            $loaded_extensions = get_loaded_extensions();
            $instance = new self($loaded_extensions);
        }
        return $instance;
    }

}