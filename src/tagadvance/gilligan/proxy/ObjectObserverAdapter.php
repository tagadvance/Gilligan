<?php

namespace tagadvance\gilligan\proxy;

class ObjectObserverAdapter implements ObjectObserver
{
    public function onUnset(ObjectUnsetEvent $event) {}

    public function onInvoke(ObjectInvokeEvent $event) {}

    public function onGet(ObjectGetEvent $event) {}

    public function onCall(ObjectCallEvent $event) {}

    public function onIsSet(ObjectIsSetEvent $event) {}

    public function onSet(ObjectSetEvent $event) {}

}
