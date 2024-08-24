<?php declare(strict_types=1);

namespace Ordo;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

final class RouterTest extends TestCase
{
	private ?Router $router;

	protected function setUp() : void
	{
		$this->router = new Router();
		Router::registerModule('admin');
		Router::registerModule('shop');
	}

	public function test_if_modules_are_registered()
	{
		$modules = Router::getModules();

		$this->assertContains('admin', $modules);
		$this->assertContains('shop', $modules);
	}

	#[DataProvider('dispatch_provider')]
	public function test_dispatch(string $uri, array $expected)
	{
		$result = $this->router->dispatch($uri);

		$this->assertEquals($expected, $result);
	}

	public static function dispatch_provider()
	{
		return
		[
			'data set 1' =>
			[
				'/',
				['app\controllers\MainController','index', [] ]
			],
			'data set 2' =>
			[
				'/main/index',
				['app\controllers\MainController','index', [] ]
			],
			'data set 3' =>
			[
				'/main/index/1/2',
				['app\controllers\MainController','index', [1,2] ]
			],
			'data set 4' =>
			[
				'/admin/main/index/1/2',
				['app\controllers\admin\MainController','index', [1,2] ]
			],
		];
	}
}