<?php

namespace tagadvance\gilligan\proxy;

use tagadvance\gilligan\observer\EventObserver;

/**
 * Notified of everything an {@link ObjectProxy} intercepts.
 * Every hook fires from a <code>finally</code>, so it is called even when the underlying
 * operation threw, and a hook that throws replaces whatever the proxy was about to return.
 */
interface ObjectObserver extends EventObserver
{
    public function onCall(ObjectCallEvent $event);

    public function onGet(ObjectGetEvent $event);

    public function onSet(ObjectSetEvent $event);

    public function onIsSet(ObjectIsSetEvent $event);

    public function onUnset(ObjectUnsetEvent $event);

    public function onInvoke(ObjectInvokeEvent $event);

}
