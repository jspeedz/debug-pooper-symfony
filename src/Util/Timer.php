<?php
namespace Jspeedz\DebugPooper\Util;

use Closure;
use Exception;

/**
 * Usage example:
 * $timer = \Jspeedz\DebugPooper\Util\Timer::startTimer();
 * sleep(1);
 * $timeInMs = $timer();
 */
class Timer {
    /**
     * Start measure point
     *
     * @return Closure Execute the callable to end and and get the measured time
     * @throws Exception
     */
    public static function startTimer(): Closure {
        $start = microtime(true);

        return function() use ($start) {
            return self::endTimer($start);
        };
    }

    /**
     * End the timer and get the value.
     *
     * @param float $start
     * @return float The time the timer took to complete, in milliseconds
     */
    private static function endTimer($start): float {
        $end = microtime(true);

        return ($end - $start) * 1000;
    }
}
