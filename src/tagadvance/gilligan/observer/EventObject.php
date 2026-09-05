<?php

namespace tagadvance\gilligan\observer;

/**
 * The base notification: what raised it, and when.
 */
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

    /**
     * @param int $when milliseconds since the epoch, as {@link \tagadvance\gilligan\base\System::currentTimeMillis()}
     *        reports it
     */
    public function __construct(\stdClass $source, int $when)
    {
        $this->source = $source;
        $this->when = $when;
    }

    public function getSource(): \stdClass
    {
        return $this->source;
    }

    /**
     * @return int milliseconds since the epoch, so divide by 1000 before handing it to date()
     */
    public function getWhen(): int
    {
        return $this->when;
    }

}
