<?php

namespace tagadvance\gilligan\proxy\object;

class ObjectCallEvent extends ObjectEventObject {

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

    function __construct(\stdClass $source, int $when, string $name, array $arguments) {
        parent::__construct($source, $when);
        $this->name = $name;
        $this->arguments = $arguments;
    }

    function getName(): string {
        return $this->name;
    }

    function getArguments(): array {
        return $this->arguments;
    }

}