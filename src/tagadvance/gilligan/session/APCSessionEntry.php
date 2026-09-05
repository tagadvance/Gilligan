<?php

namespace tagadvance\gilligan\session;

/**
 * A drop-in replacement session handler which saves data to APC.
 */
class APCSessionEntry implements \Serializable
{
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

    public function __construct(string $id, $data, array $meta)
    {
        $this->id = $id;
        $this->data = $data;
        $this->meta = $meta;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): void
    {
        $this->data = $data;
    }

    public function getMeta(): array
    {
        return $this->meta;
    }

    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->data,
            $this->meta,
        ]);
    }

    public function unserialize($serialized)
    {
        list($this->id, $this->data, $this->meta) = unserialize($serialized);
    }

}
