<?php declare(strict_types=1);

namespace Ordo;

use PHPUnit\Framework\TestCase;

use Ordo\Security\SecurityHandler;
use Ordo\Session;

final class SecurityHandlerTest extends TestCase
{
	private ?Session $session;
	private ?SecurityHandler $sh;

	protected function setUp() : void
	{
		$this->session = new Session();
		$this->sh = new SecurityHandler($this->session);
		define('USER_SESSION_KEY', 'USER');
	}

	public function test_if_user_is_initialized()
	{
		$this->sh->initUser();
		$this->assertArrayHasKey('USER', $_SESSION);
	}
}