<?php

namespace tagadvance\gilligan\cryptography;

use tagadvance\gilligan\io\File;
use tagadvance\gilligan\io\Closeable;

class Certificate implements Closeable {

    /**
     *
     * @var resource
     */
    private $certificate;

    static function createFromFile(File $file): self {
        $path = $file->getRealPath();
        $filePath = "file://$path";
        $certificate = openssl_x509_read($filePath);
        if ($certificate === false) {
            throw new CryptographyException();
        }
        return new self($certificate);
    }

    function __construct($certificate) {
        if (! is_resource($certificate)) {
            $message = '$certificate must be a resource';
            throw new \InvalidArgumentException($message);
        }
        
        $this->certificate = $certificate;
    }

    function getCertificate() {
        return $this->certificate;
    }

    function export($includeHumanReadableInformation = false): string {
        $output = '';
        $isExported = openssl_x509_export($this->certificate, $output, ! $includeHumanReadableInformation);
        if (! $isExported) {
            throw new CryptographyException();
        }
        return $output;
    }

    function exportToFile(\SplFileInfo $file, $includeHumanReadableInformation = false): string {
        $filePath = $file->getRealPath();
        $isExported = openssl_x509_export_to_file($this->certificate, $filePath, ! $includeHumanReadableInformation);
        if (! $isExported) {
            throw new CryptographyException();
        }
        return $out;
    }

    function close() {
        openssl_x509_free($this->certificate);
    }

}