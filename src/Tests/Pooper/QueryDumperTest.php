<?php
namespace Jspeedz\DebugPooper\Pooper {
	/**
	 * Override the dump method so we can test it
	 * @param $var
	 *
	 * @return false|string
	 */
	function 💩($var) {
		return json_encode($var);
	}
}

namespace Jspeedz\DebugPooper\Tests\Pooper {
    use Doctrine\DBAL\ArrayParameterType;
    use Doctrine\DBAL\ParameterType;
    use Jspeedz\DebugPooper\Exception\InvalidParameterCountException;
    use Jspeedz\DebugPooper\Exception\InvalidTypeException;
    use Jspeedz\DebugPooper\Pooper\QueryDumper;
	use PHPUnit\Framework\TestCase;

    enum UnbackedEnumeration {
        case TEST;
    }

	class QueryDumperTest extends TestCase {
		public function testQueryDumperWithoutParameters() {
			$result = QueryDumper::dump('SELECT 1 FROM x', [], [], true);

			$this->assertEquals('SELECT 1 FROM x', $result);
		}

		public function testQueryDumper💩IsCalled() {
			$this->assertEquals(
				'"SELECT 1 FROM x"',
				QueryDumper::dump('SELECT 1 FROM x', [], [], false)
			);
		}

		public function testQueryDumperWithParameters() {
			$result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = ? OR x.z = ? AND x.x = ? AND x.a IN(?) AND x.b IN(?)', [
				1,
				'2',
				'abc',
				[1, 2, 3],
				['a', 'b', 'c'],
			], [], true);

			$this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = 2 AND x.x = "abc" AND x.a IN(1, 2, 3) AND x.b IN("a", "b", "c")', $result);
		}

		public function testQueryDumperWithAliasedParameters() {
			$result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = :param1 OR x.z = :param2 AND x.x = :param3 AND x.a IN(:param4) AND x.b IN(:param5)', [
				'param1' => 1,
				'param2' => '2',
				'param3' => 'abc',
				'param4' => [1, 2, 3],
				'param5' => ['a', 'b', 'c'],
			], [], true);

			$this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = 2 AND x.x = "abc" AND x.a IN(1, 2, 3) AND x.b IN("a", "b", "c")', $result);
		}

        public function testQueryDumperWithAliasedParametersEndingOnSelf() {
            $result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = :dingExtended OR x.z = :ding', [
                'ding' => 'a',
                'dingExtended' => 'b',
            ], [], true);

            $this->assertEquals('SELECT 1 FROM x WHERE x.y = "b" OR x.z = "a"', $result);
        }

		public function testQueryDumperWithParametersAndTypes() {
			$result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = ? OR x.z = ? AND x.a IN(?) AND x.b IN(?)', [
				1,
				2,
				[1, 2, 3],
				['a', 'b', 'c'],
			], [
                ParameterType::INTEGER,
                ParameterType::STRING,
                ArrayParameterType::INTEGER,
                ArrayParameterType::STRING,
			], true);

			$this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = "2" AND x.a IN(1, 2, 3) AND x.b IN("a", "b", "c")', $result);
		}

		public function testQueryDumperWithAliasedParametersAndTypes() {
			$result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = :param1 OR x.z = :param2 AND x.a IN(:param3) AND x.b IN(:param4)', [
				'param1' => 1,
				'param2' => 2,
				'param3' => [1, 2, 3],
				'param4' => ['a', 'b', 'c'],
			], [
                ParameterType::INTEGER,
                ParameterType::STRING,
                ArrayParameterType::INTEGER,
                ArrayParameterType::STRING,
			], true);

			$this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = "2" AND x.a IN(1, 2, 3) AND x.b IN("a", "b", "c")', $result);
		}

		public function testInvalidParameterCountException() {
            $this->expectException(InvalidParameterCountException::class);

			QueryDumper::dump('x', [1, 2], [1, 2, 4]);
		}

		public function testInvalidTypeException() {
            $this->expectException(InvalidTypeException::class);
            $this->expectExceptionMessage(UnbackedEnumeration::TEST->name);

			QueryDumper::dump('x', [1], [UnbackedEnumeration::TEST]);
		}
	}
}
