<?php
namespace Jspeedz\DebugPooper\Tests\Pooper;

use Jspeedz\DebugPooper\Pooper\SimpleXmlElementTreeDumper;
use PHPUnit\Framework\TestCase;

class SimpleXmlElementTreeDumperTest extends TestCase {
    public function testDumpReturnOutputWithoutStringContent() {
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

        $result = SimpleXmlElementTreeDumper::dump($element, false, true);
        $result = str_replace("\n", "", $result);
        $result = str_replace("\r", "", $result);

        $expected = "SimpleXML object (1 item)[0] // <root>	->this[0]		->is[0]		->test[0]			->that[0]		->z[0]			['our']";
        $expected = str_replace("\n", "", $expected);
        $expected = str_replace("\r", "", $expected);

        $this->assertEquals($expected, $result);
    }

    public function testDumpReturnOutputWithStringContent() {
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

        $result = SimpleXmlElementTreeDumper::dump($element, true, true);

        $result = str_replace("\n", "", $result);
        $result = str_replace("\r", "", $result);

        $expected = "SimpleXML object (1 item)[0] // <root>	(string) '' (6 chars)	->this[0]		(string) '' (32 chars)		->is[0]			(string) 'Some' (4 chars)		->test[0]			(string) '' (22 chars)			->that[0]				(string) 'Will validate' (13 chars)		->z[0]			(string) 'xx' (2 chars)			['our']				(string) 'dumper' (6 chars)";
        $expected = str_replace("\n", "", $expected);
        $expected = str_replace("\r", "", $expected);

        $this->assertEquals($expected, $result);
    }
}
