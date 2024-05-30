<?php
namespace tests;

class Test
{
	public static array $messages = [];
	public static int $assertCount = 0;
	public static int $testCount = 0;
	protected string $currentClass = '';
	protected string $currentMethod = '';

	public function __construct()
	{
		static::$testCount++;
	}

	protected function runBefore($currentClass, $currentMethod)
	{
		$this->currentMethod = $currentMethod;
		$this->currentClass = $currentClass;
	}

	public function assertTrue(bool $val)
	{
		static::$assertCount++;
		if($val != true)
		{
			$val = $val ? $val : 'false';
			$this->failure("Failed asserting that $val is true.");	
		}
	}

	public function assertFalse(bool $val)
	{
		static::$assertCount++;
		if($val != false)
		{
			$this->failure("Failed asserting that $val is false.");	
		}
	}

	// $val1 - expected value
	// $val2 - received value
	public function assertEqual($val1, $val2)
	{
		static::$assertCount++;
		if($val1 != $val2)
		{
			$this->failure('Failed asserting that two variables have equal values.', [$val1,$val2]);
		}
	}

	public function assertNotEqual($val1, $val2)
	{
		static::$assertCount++;
		if(strcmp($val1, $val2) == 0)
		{
			$this->failure('Failed asserting that two strings are not equal.', [$val1,$val2]);
		}
	}

	public function assertSame($val1, $val2)
	{
		static::$assertCount++;
		if($val1 !== $val2)
		{
			$this->failure('Failed asserting that two variables have the same values.', [$val1,$val2]);
		}
	}

	public function assertNotSame($val1, $val2)
	{
		static::$assertCount++;
		if($val1 === $val2)
		{
			$this->failure('Failed asserting that two variables have not the same values.', [$val1,$val2]);
		}
	}

	// assertArrayEqual
	public function assertArrayEqual($arr1, $arr2)
	{

	}
	// assertObjectEqual
	public function assertObjectEqual($obj1, $obj2)
	{
		
	}

	private function failure(string $message, array $values = [])
	{
		static::$messages[] = [
			'text' => $message,
			'data' => empty($values) ? [] : [$values[0], $values[1]],
			'place' => $this->currentClass . '::' . $this->currentMethod,
		];	
	}
}