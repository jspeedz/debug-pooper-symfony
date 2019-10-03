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
	use Doctrine\DBAL\Connection;
	use Jspeedz\DebugPooper\Pooper\QueryDumper;
	use PDO;
	use PHPUnit\Framework\TestCase;

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

		public function testQueryDumperWithParametersAndTypes() {
			$result = QueryDumper::dump('SELECT 1 FROM x WHERE x.y = ? OR x.z = ? AND x.a IN(?) AND x.b IN(?)', [
				1,
				2,
				[1, 2, 3],
				['a', 'b', 'c'],
			], [
				PDO::PARAM_INT,
				PDO::PARAM_STR,
				Connection::PARAM_INT_ARRAY,
				Connection::PARAM_STR_ARRAY,
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
				PDO::PARAM_INT,
				PDO::PARAM_STR,
				Connection::PARAM_INT_ARRAY,
				Connection::PARAM_STR_ARRAY,
			], true);

			$this->assertEquals('SELECT 1 FROM x WHERE x.y = 1 OR x.z = "2" AND x.a IN(1, 2, 3) AND x.b IN("a", "b", "c")', $result);
		}

		/**
		 * @expectedException \Jspeedz\DebugPooper\Exception\InvalidParameterCountException
		 */
		public function testInvalidParameterCountException() {
			QueryDumper::dump('x', [1, 2], [1, 2, 4]);
		}
		/**
		 * @expectedException \Jspeedz\DebugPooper\Exception\InvalidTypeException
		 */
		public function testInvalidTypeException() {
			QueryDumper::dump('x', [1], [-10]);
		}
	}
}
