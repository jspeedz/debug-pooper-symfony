<?php
use Jspeedz\DebugPooper\Pooper\SimpleXmlElementTreeDumper;

if(!function_exists('dumpSimpleXmlElementTree')) {
    /**
     * @param SimpleXMLElement $simpleXMLElement
     * @param bool $includeStringContent = true If true, will summarise textual content, as well as child elements and attribute names
     * @param bool $return = false
     *
     * @return void
     */
    function dumpSimpleXmlElementTree(SimpleXMLElement $simpleXMLElement, bool $includeStringContent = true, bool $return = false): void {
        SimpleXmlElementTreeDumper::dump($simpleXMLElement, $includeStringContent, $return);
    }
}
