<?php
namespace Jspeedz\DebugPooper\Pooper;

// Load the global 💩() function (and in extension, dump())
require_once __DIR__ . '/../Component/VarDumper/Resources/functions/dump.php';
// Load the global dumpRequest() function
require_once __DIR__ . '/../Component/VarDumper/Resources/functions/dumprequest.php';

class RequestDumper {
	/**     *
	 * @param bool $output Returns the result instead of dumping if true
	 *
	 * @return null|string Depends on $output
	 */
	public static function dump(bool $output = false): ?string {
		$result = [
			'method' => getenv('REQUEST_METHOD'),
			'post' => $_POST,
			'get' => $_GET,
			'cookies' => $_COOKIE,
			'request_headers' => getallheaders(),
		];


		if($output) {
			return $result;
		}

		💩($result);
	}
}
