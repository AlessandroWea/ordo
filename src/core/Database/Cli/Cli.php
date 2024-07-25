<?php

namespace Ordo\Database\Cli;

use Ordo\Database\Db;

class Cli
{
	private array $argv = [];

	private array $types = [
		'int','string'
	];

	public function __construct($argv)
	{
		$this->argv = $argv;
	}

	public function run()
	{
		if(count($this->argv) <= 1)
			return;
		try {
			$command = $this->argv[1];
			switch ($command) {
				case 'make_db':
					$this->createDatabase();
					break;
				case 'make_entity':
					$this->createEntity();
					break;
				default:
					// code...
					break;
			}		
		} catch(\PDOException $ex)
		{
			echo($ex->getMessage() . "\n");
		}

	}

	public function createDatabase()
	{
		$db = Db::connectWithoutDb();
		$ret = $db->query(' CREATE DATABASE ' . DB_NAME);
		echo "Database '" . DB_NAME . "' was created!\n";
	}

	public function createEntity()
	{
		$db = Db::connect();
		$stdin = fopen('php://stdin', 'r');
		$parameters = [];

		echo "Adding a new parameter:" . "\n";
		while(($name = trim(fgets($stdin))) !== '')
		{
			echo "Choose a type:" . "\n";
			$type = trim(fgets($stdin));
			while(!in_array($type, $this->types) || $type == '')
			{
				echo 'Invalid type! Choose valid:' . "\n";
				$type = trim(fgets($stdin));
			}

			$parameters[] = [
				'name' => $name,
				'type' => $type
			];
			var_dump($parameters);

			echo "Adding a new parameter:" . "\n";
		}
	}
}