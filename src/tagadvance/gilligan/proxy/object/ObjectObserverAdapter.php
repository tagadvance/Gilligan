<?php

namespace tagadvance\gilligan\proxy\object;

class ObjectObserverAdapter implements ObjectObserver {

    function onUnset(ObjectUnsetEvent $event) {}

    function onInvoke(ObjectInvokeEvent $event) {}

    function onGet(ObjectGetEvent $event) {}

    function onCall(ObjectCallEvent $event) {}

    function onIsSet(ObjectIsSetEvent $event) {}

    function onSet(ObjectSetEvent $event) {}

}