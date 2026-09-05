<?php

namespace tagadvance\gilligan\io;

/**
 * An {@link OutputStream} over an already-open PHP stream resource.
 * It takes ownership: {@link self::close()} fcloses the handle the caller passed in.
 */
class ResourceOutputStream implements OutputStream
{
    protected $handle;

    /**
     * A stream over <code>php://output</code>, which passes through PHP's output buffering
     * rather than going straight to a file descriptor.
     */
    public static function createDefaultOutputStream()
    {
        $handle = fopen('php://output', FileMode::WRITE_ONLY_APPEND);
        return new self($handle);
    }

    /**
     * @param resource $handle
     * @throws \InvalidArgumentException when <code>$handle</code> is not a resource
     */
    public function __construct(/* resource */ $handle)
    {
        if (! is_resource($handle)) {
            $message = '$handle must be a resource';
            throw new \InvalidArgumentException($message);
        }
        $this->handle = $handle;
    }

    public function write(string $string, ?int $length = null): int
    {
        if ($length === null) {
            $byteCount = fwrite($this->handle, $string);
        } else {
            $byteCount = fwrite($this->handle, $string, $length);
        }
        if ($byteCount === false) {
            throw new IOException();
        }
        return $byteCount;
    }

    public function flush()
    {
        $isFlushed = fflush($this->handle);
        if (! $isFlushed) {
            throw new IOException();
        }
    }

    public function close()
    {
        $isClosed = fclose($this->handle);
        if (! $isClosed) {
            throw new IOException();
        }
    }

}
