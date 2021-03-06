<?php

namespace tagadvance\gilligan\proxy;


class ObjectUnsetEvent extends ObjectEventObject {

    /**
     *
     * @var string
     */
    private $name;

    function __construct(\stdClass $source, int $when, string $name) {
        parent::__construct($source, $when);
        $this->name = $name;
    }

    function getName(): string {
        return $this->name;
    }

}