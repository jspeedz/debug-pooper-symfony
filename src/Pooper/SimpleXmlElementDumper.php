<?php
namespace Jspeedz\DebugPooper\Pooper;

use SimpleXMLElement;

require_once __DIR__ . '/../../vendor-nopackage/simplexml_debug-1.0.0/src/simplexml_dump.php';

// Load the global 💩() function (and in extension, dump())
require_once __DIR__ . '/../Component/VarDumper/Resources/functions/dump.php';

class SimpleXmlElementDumper {
    /**
     * @param SimpleXMLElement $element
     * @param bool $return
     *
     * @return string|null
     */
    public static function dump(SimpleXMLElement $element, bool $return = false) {
        $result = simplexml_dump($element, true);

        if(!$return) {
            dump($result);

            return null;
        }
        else {
            return $result;
        }
    }
}