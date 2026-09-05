<?php

namespace tagadvance\gilligan\proxy;

/**
 * A method call that reached the proxied object.
 */
class ObjectCallEvent extends ObjectEventObject
{
    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var array
     */
    private $arguments;

    public function __construct(\stdClass $source, int $when, string $name, array $arguments)
    {
        parent::__construct($source, $when);
        $this->name = $name;
        $this->arguments = $arguments;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array the call's arguments, positionally, exactly as the caller passed them
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

}
