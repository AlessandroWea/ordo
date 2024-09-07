<?php declare(strict_types=1);

namespace Ordo;

use PHPUnit\Framework\TestCase;

use Ordo\Validators\Constraints\Blank;
use Ordo\Validators\Constraints\BlankValidator;

final class BlankValidatorTest extends TestCase
{
	private ?Blank $constraint;
	private ?BlankValidator $validator;

	protected function setUp() : void
	{
		$this->constraint = new Blank();
		$this->validator = new BlankValidator;
	}

	public function test_validate()
	{
		$value = '';
		$this->assertTrue($this->validator->validate($value, $this->constraint));

		$value = 'e';
		$this->assertFalse($this->validator->validate($value, $this->constraint));
	}
}