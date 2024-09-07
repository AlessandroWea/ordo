<?php declare(strict_types=1);

namespace Ordo;

use PHPUnit\Framework\TestCase;

use Ordo\Validators\Constraints\NotNull;
use Ordo\Validators\Constraints\NotNullValidator;

final class NotNullValidatorTest extends TestCase
{
	private ?NotNull $constraint;
	private ?NotNullValidator $validator;

	protected function setUp() : void
	{
		$this->constraint = new NotNull();
		$this->validator = new NotNullValidator;
	}

	public function test_validate()
	{
		$value = null;
		$this->assertFalse($this->validator->validate($value, $this->constraint));

		$value = 'dd';
		$this->assertTrue($this->validator->validate($value, $this->constraint));
	}
}