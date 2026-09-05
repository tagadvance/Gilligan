<?php

namespace tagadvance\gilligan\observer;

class EventObject
{
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

    public function __construct(\stdClass $source, int $when)
    {
        $this->source = $source;
        $this->when = $when;
    }

    public function getSource(): \stdClass
    {
        return $this->source;
    }

    public function getWhen(): int
    {
        return $this->when;
    }

}
