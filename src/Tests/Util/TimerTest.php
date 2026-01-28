<?php
namespace Jspeedz\DebugPooper\Tests\Util;

use Jspeedz\DebugPooper\Util\Timer;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase {
    public function testTimer() {
        $start = microtime(true);

        $timer = Timer::startTimer();
        $this->assertIsCallable($timer);
        $result = $timer();

        $wrapperEndMs = (microtime(true) - $start) * 1000;

        $this->assertIsFloat($result);
        $this->assertGreaterThan(0, $result);
        $this->assertLessThan($wrapperEndMs, $result);
    }
}