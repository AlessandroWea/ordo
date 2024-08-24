<?php declare(strict_types=1);

namespace Ordo;

use PHPUnit\Framework\TestCase;

use Ordo\Session;

final class SessionTest extends TestCase
{
	private ?Session $session;

	protected function setUp() : void
	{
		$this->session = new Session();
		$this->session->set('username', 'alex');
		$this->session->set('ages', [1,2,3]);
	}

	public function test_if_values_are_set()
	{
		$this->assertArrayHasKey('username', $_SESSION);
		$this->assertEquals($this->session->get('username'), 'alex');
	}

	public function test_if_has_values()
	{
		$this->assertTrue($this->session->has('username'));
		$this->assertTrue(true);
	}

}