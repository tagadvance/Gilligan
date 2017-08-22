<?php

namespace tagadvance\gilligan\observer;

class EventObject {

    /**
     *
     * @var \stdClass
     */
    private $source;

    /**
     *
     * @var int
     */
    private $when;

    function __construct(\stdClass $source, int $when) {
        $this->source = $source;
        $this->when = $when;
    }

    function getSource(): \stdClass {
        return $this->source;
    }

    function getWhen(): int {
        return $this->when;
    }

}