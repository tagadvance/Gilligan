<?php

namespace tagadvance\gilligan\proxy;

class ObjectSetEvent extends ObjectEventObject
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var unknown
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

    public function getValue()
    {
        return $this->value;
    }

}
