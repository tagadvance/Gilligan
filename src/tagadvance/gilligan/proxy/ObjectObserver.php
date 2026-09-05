<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\observer\EventObserver;

interface ObjectObserver extends EventObserver
{
    public function onCall(ObjectCallEvent $event);

    public function onGet(ObjectGetEvent $event);

    public function onSet(ObjectSetEvent $event);

    public function onIsSet(ObjectIsSetEvent $event);

    public function onUnset(ObjectUnsetEvent $event);

    public function onInvoke(ObjectInvokeEvent $event);

}
