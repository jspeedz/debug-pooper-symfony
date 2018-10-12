<?php
namespace Jspeedz\DebugPooper\Tests\Pooper;

use Jspeedz\DebugPooper\Pooper\QueryDumper;
use PDO;
use PHPUnit\Framework\TestCase;

class QueryDumperTest extends TestCase {
    public function testQueryDumperWithoutParameters() {
        $result = QueryDumper::dump('SELECT 1 FROM x', [], [], true);

        $this->assertEquals('SELECT 1 FROM x', $result);
    }

    public function testQueryDumperWithParameters() {
        $result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = ? OR x.z = ?', [
            1,
            '2',
        ], [], true);

        $this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = 2', $result);
    }

    public function testQueryDumperWithAliasedParameters() {
        $result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = :param1 OR x.z = :param2', [
            'param1' => 1,
            'param2' => '2',
        ], [], true);

        $this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = 2', $result);
    }

    public function testQueryDumperWithParametersAndTypes() {
        $result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = ? OR x.z = ?', [
            1,
            2,
        ], [
            PDO::PARAM_INT,
            PDO::PARAM_STR,
        ], true);

        $this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = "2"', $result);
    }

    public function testQueryDumperWithAliasedParametersAndTypes() {
        $result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = :param1 OR x.z = :param2', [
            'param1' => 1,
            'param2' => 2,
        ], [
            PDO::PARAM_INT,
            PDO::PARAM_STR,
        ], true);

        $this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = "2"', $result);
    }
}