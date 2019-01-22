<?php
namespace Jspeedz\DebugPooper\Tests\Pooper;

require_once __DIR__ . '/../DummyGetAllHeaders.php';

use Jspeedz\DebugPooper\Pooper\RequestDumper;
use PHPUnit\Framework\TestCase;

class RequestDumperTest extends TestCase {
    public function testDumpReturnOutput() {
        putenv('REQUEST_METHOD=POST');
        $_POST['X'] = 'z';
        $_GET['Y'] = 'x';
        $_COOKIE['Z'] = 'y';

        $result = RequestDumper::dump(true);
        $this->assertArrayHasKey('method', $result);
        $this->assertArrayHasKey('post', $result);
        $this->assertArrayHasKey('get', $result);
        $this->assertArrayHasKey('cookies', $result);
        $this->assertArrayHasKey('request_headers', $result);

        $this->assertEquals('POST', $result['method']);
        $this->assertEquals($_POST, $result['post']);
        $this->assertEquals($_GET, $result['get']);
        $this->assertEquals($_COOKIE, $result['cookies']);
        $this->assertEquals(getallheaders(), $result['request_headers']);
    }
}
