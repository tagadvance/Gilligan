<?php

namespace tagadvance\gilligan\proxy\object;

class ObjectInvokeEvent extends ObjectEvent {

    function __construct(\stdClass $source, int $when) {
        parent::__construct($source, $when);
    }

}