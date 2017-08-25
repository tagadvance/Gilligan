<?php

namespace tagadvance\gilligan\session;

/**
 * A drop-in replacement session handler which saves data to APC.
 */
class APCSessionEntry implements \Serializable {

    /**
     *
     * @var string
     */
    private $id;

    /**
     *
     * @var mixed
     */
    private $data;

    /**
     *
     * @var array
     */
    private $meta;

    function __construct(string $id, $data, array $meta) {
        $this->id = $id;
        $this->data = $data;
        $this->meta = $meta;
    }

    function getId(): string {
        return $this->id;
    }

    function getData() {
        return $this->data;
    }

    function setData($data): void {
        $this->data = $data;
    }

    function getMeta(): array {
        return $this->meta;
    }

    function setMeta(array $meta): void {
        $this->meta = $meta;
    }

    function serialize() {
        return serialize([
                $this->id,
                $this->data,
                $this->meta
        ]);
    }

    function unserialize($serialized) {
        list ($this->id, $this->data, $this->meta) = unserialize($serialized);
    }

}