<?php

namespace tagadvance\gilligan\proxy\object;

class ObjectInvokeEvent extends ObjectEventObject {

    function __construct(\stdClass $source, int $when) {
        parent::__construct($source, $when);
    }

}