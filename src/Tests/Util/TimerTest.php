<?php
namespace Jspeedz\DebugPooper\Tests\Util;

use Jspeedz\DebugPooper\Util\Timer;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Constraint\IsType;

class TimerTest extends TestCase {
    public function testTimer() {
        $start = microtime(true);

        $timer = Timer::startTimer();
        $this->assertInternalType(IsType::TYPE_CALLABLE, $timer);
        $result = $timer();

        $wrapperEndMs = (microtime(true) - $start) * 1000;

        $this->assertInternalType(IsType::TYPE_FLOAT, $result);
        $this->assertGreaterThan(0, $result);
        $this->assertLessThan($wrapperEndMs, $result);
    }
}