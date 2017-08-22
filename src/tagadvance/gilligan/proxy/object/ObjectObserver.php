<?php

namespace tagadvance\gilligan\proxy\object;

use tagadvance\gilligan\observer\EventObserver;

interface ObjectObserver extends EventObserver {

    function onCall(ObjectCallEvent $event);

    function onGet(ObjectGetEvent $event);

    function onSet(ObjectSetEvent $event);

    function onIsSet(ObjectIsSetEvent $event);

    function onUnset(ObjectUnsetEvent $event);

    function onInvoke(ObjectInvokeEvent $event);

}