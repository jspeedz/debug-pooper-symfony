<?php
namespace Jspeedz\DebugPooper\Pooper;

use SimpleXMLElement;

require_once __DIR__ . '/../../vendor-nopackage/simplexml_debug-1.0.0/src/simplexml_tree.php';

// Load the global 💩() function (and in extension, dump())
require_once __DIR__ . '/../Component/VarDumper/Resources/functions/dump.php';

class SimpleXmlElementTreeDumper {
    /**
     * @param SimpleXMLElement $element
     * @param bool $includeStringContent = true If true, will summarise textual content, as well as child elements and attribute names
     * @param bool $return = false
     *
     * @return string|null
     */
    public static function dump(SimpleXMLElement $element, bool $includeStringContent = true, bool $return = false) {
        $result = simplexml_tree($element, $includeStringContent, true);

        if(!$return) {
            dump($result);

            return null;
        }
        else {
            return $result;
        }
    }
}