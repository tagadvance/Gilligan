<?php

namespace tagadvance\gilligan\proxy;

/**
 * The proxy itself being called as a function.
 * It carries no arguments — {@link ObjectProxy::__invoke()} does not record them.
 */
class ObjectInvokeEvent extends ObjectEventObject
{
    public function __construct(\stdClass $source, int $when)
    {
        parent::__construct($source, $when);
    }

}
