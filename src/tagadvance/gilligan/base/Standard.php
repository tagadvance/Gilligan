<?php

namespace tagadvance\gilligan\base;

use tagadvance\gilligan\io\PrintStream;
use tagadvance\gilligan\io\ResourceOutputStream;
use tagadvance\gilligan\io\ResourceInputStream;

/**
 * Java-style handles on the process's standard streams.
 *
 * @author Tag <tagadvance+gilligan@gmail.com>
 *
 */
class Standard
{
    /**
     * The shared STDIN stream — every caller gets the same instance, so a read consumes those
     * bytes for all of them.
     */
    public static function in(): ResourceInputStream
    {
        static $stream = null;
        if ($stream === null) {
            $stream = new ResourceInputStream(STDIN);
        }
        return $stream;
    }

    /**
     * The shared STDOUT stream.
     * The <code>STDOUT</code> constant exists only under the CLI SAPI, so reach for
     * {@link self::output()} from a web request.
     */
    public static function out(): PrintStream
    {
        static $stream = null;
        if ($stream === null) {
            $stream = new PrintStream(new ResourceOutputStream(STDOUT));
        }
        return $stream;
    }

    /**
     * The shared STDERR stream.
     * The <code>STDERR</code> constant exists only under the CLI SAPI.
     */
    public static function err(): PrintStream
    {
        static $stream = null;
        if ($stream === null) {
            $stream = new PrintStream(new ResourceOutputStream(STDERR));
        }
        return $stream;
    }

    /**
     * The shared <code>php://output</code> stream, which works under every SAPI and passes
     * through PHP's output buffering rather than going straight to a file descriptor.
     */
    public static function output()
    {
        static $stream = null;
        if ($stream === null) {
            $stream = new PrintStream(ResourceOutputStream::createDefaultOutputStream());
        }
        return $stream;
    }

    private function __construct() {}

}
