<?php

namespace tagadvance\gilligan\session;

/**
 * One session as {@link APCSessionHandler} stores it: the id, the serialized session data, and
 * a bag of metadata.
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

    public function __serialize(): array
    {
        return [
            $this->id,
            $this->data,
            $this->meta,
        ];
    }

    public function __unserialize(array $data): void
    {
        list($this->id, $this->data, $this->meta) = $data;
    }

    /**
     * Part of the deprecated \Serializable interface, which this class still declares alongside
     * __serialize()/__unserialize(); PHP prefers the latter pair, so this is dead weight.
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->data,
            $this->meta,
        ]);
    }

    /**
     * Part of the deprecated \Serializable interface; see {@link self::serialize()}.
     */
    public function unserialize($serialized)
    {
        list($this->id, $this->data, $this->meta) = unserialize($serialized);
    }

}
