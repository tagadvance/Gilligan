<?php

namespace tagadvance\gilligan\time;

use PHPUnit\Framework\TestCase;

class SystemTimeProviderTest extends TestCase
{
    public function testCurrentTimeMillisisPositiveInteger()
    {
        $timeProvider = new SystemTimeProvider();
        $now = $timeProvider->currentTimeMillis();
        $this->assertTrue($now > 0);
    }

}
