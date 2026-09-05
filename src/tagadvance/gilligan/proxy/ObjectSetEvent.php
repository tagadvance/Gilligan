<?php

namespace tagadvance\gilligan\proxy;

/**
 * A property write through the proxy.
 */
class ObjectSetEvent extends ObjectEventObject
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $value;

    public function __construct(\stdClass $source, int $when, string $name, $value)
    {
        parent::__construct($source, $when);
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed the value that was assigned
     */
    public function getValue()
    {
        return $this->value;
    }

}
