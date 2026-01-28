<?php
use Jspeedz\DebugPooper\Pooper\SimpleXmlElementDumper;

if(!function_exists('dumpSimpleXmlElement')) {
    /**
     * @param SimpleXMLElement $simpleXMLElement
     * @param bool $return = false
     *
     * @return void
     *
     */
    function dumpSimpleXmlElement(SimpleXMLElement $simpleXMLElement, bool $return = false): void {
        SimpleXmlElementDumper::dump($simpleXMLElement, $return);
    }
}
