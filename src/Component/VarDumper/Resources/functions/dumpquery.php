<?php
use Jspeedz\DebugPooper\Pooper\QueryDumper;

if(!function_exists('dumpQuery')) {
    /**
     * @param string $query
     * @param array $parameters
     * @param int[] $types
     * @return void
     *
     * @throws Jspeedz\DebugPooper\Exception\InvalidParameterException
     */
    function dumpQuery(string $query, array $parameters = [], array $types = []): void {
        QueryDumper::dump($query, $parameters, $types);
    }
}
