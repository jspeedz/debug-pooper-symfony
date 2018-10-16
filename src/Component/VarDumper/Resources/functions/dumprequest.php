<?php
use Jspeedz\DebugPooper\Pooper\RequestDumper;

if(!function_exists('dumpRequest')) {
    /**
     * @return void
     */
    function dumpRequest(): void {
        RequestDumper::dump();
    }
}
