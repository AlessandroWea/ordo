<?php
namespace tests\core;

use Ordo\Database\QueryBuilder;

use tests\Test;

class QueryBuilderTest extends Test
{
	public function selectTest()
	{
		$qb = new QueryBuilder();

		$res = $qb->select(QueryBuilder::ALL_COLUMNS)
					->from('users', 'u')
					->where('name = :name')
					->setParameter(':name', 'Name')
					->getQuery()
		;

		$this->assertEqual(
			"1",1
		);

		$this->assertSame(
			1,"1"
		);
	}

	public function deleteTest()
	{
		$qb = new QueryBuilder();

		$res = $qb->select(QueryBuilder::ALL_COLUMNS)
					->from('users', 'u')
					->where('name = :name')
					->setParameter(':name', 'Name')
					->getQuery()
		;

		$this->assertEqual(
			$res,
			'SELECT * FROM users u WHERE name = :name LIMIT 100 OFFSET 0'
		);
	}
}