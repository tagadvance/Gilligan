<?php

namespace tagadvance\gilligan\proxy;

/**
 * An isset() test against the proxy.
 */
class ObjectIsSetEvent extends ObjectEventObject
{
    /**
     *
     * @var string
     */
    private $name;

    public function __construct(\stdClass $source, int $when, string $name)
    {
        parent::__construct($source, $when);
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

}
