<?php
use Jspeedz\DebugPooper\Util\Timer;

if(!function_exists('debugTimer')) {
    /**
     * @return Closure
     * @throws Exception
     */
    function debugTimer(): \Closure {
        return Timer::startTimer();
    }
}
