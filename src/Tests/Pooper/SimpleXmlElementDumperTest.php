<?php
namespace Jspeedz\DebugPooper\Tests\Pooper;

use Jspeedz\DebugPooper\Pooper\SimpleXmlElementDumper;
use PHPUnit\Framework\TestCase;

class SimpleXmlElementDumperTest extends TestCase {
    public function testDumpReturnOutput() {
        $element = simplexml_load_string('<?xml version="1.0" encoding="utf-8" ?>
<root>
    <this>
        <is>Some</is>
        <test>
            <that>Will validate</that>
        </test>
        <z our="dumper">xx</z>
    </this>
</root>');

        $result = SimpleXmlElementDumper::dump($element, true);

        $this->assertEquals("SimpleXML object (1 item)\r\n[
	Element {
		Name: 'root'
		String Content: '\n    \n'
		Content in Default Namespace
			Children: 1 - 1 'this'
			Attributes: 0
	}
]
", $result);
    }
}
