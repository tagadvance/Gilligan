<?php

namespace tagadvance\gilligan\proxy;

class ObjectInvokeEvent extends ObjectEventObject
{
    public function __construct(\stdClass $source, int $when)
    {
        parent::__construct($source, $when);
    }

}
