<?php

session_start();

use tests\Test;

define('ROOT', dirname(__FILE__));
define('SERVER_PATH', '/');

require_once '../src/config.php';
require_once '../vendor/autoload.php';
require_once '../src/functions.php';
$dir = '../src/tests/core/';
$testsFiles = [];
// find all tests
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
        	if(filetype($dir . $file) !== 'file')
        		continue;

        	if(preg_match('#^[A-z]+Test.php$#', $file))
        	{
        		$testsFiles[] = $file;
        	}
        }
        closedir($dh);
    }
}

// dd($testsFiles);

// create all tests
foreach ($testsFiles as $file) {
	$file = rtrim($file, '.php');
	$reflObj = new \ReflectionClass('tests\core\\' . $file);
	$testObj = $reflObj->newInstanceArgs();
	$methods = $reflObj->getMethods();
	$runBeforeMethod = $reflObj->getMethod('runBefore');

	$testMethods = [];
	foreach($methods as $method)
	{
		if(preg_match('#^[A-z]+Test$#', $method->name))
		{
			$testMethods[] = $method;
		}	
	}
	// dd($testMethods);
	foreach($testMethods as $method)
	{
		$runBeforeMethod->invokeArgs($testObj, [$reflObj->getName(), $method->name]);
		$method->invoke($testObj);
	}
}

if(empty(Test::$messages))
{
	print("Tests: " . Test::$testCount . " Assertions: " . Test::$assertCount . " Failed: 0" . "\n");
}
else
{
	$failures = count(Test::$messages);
	print("There was $failures failures\n\n");
	$count = 1;
	foreach (Test::$messages as $message) {
		print("$count) " . $message['place'] . "\n");
		print($message['text'] . "\n");
		if(!empty($message['data']))
		{
			print('exp: ' . quoteIfString($message['data'][0]) . "\n");
			print('rec: ' . quoteIfString($message['data'][1]) . "\n");			
		}
		$count++;
	}
	print("\nFAILURES!\n");
	print("Tests: " . Test::$testCount . " Assertions: " . Test::$assertCount . " Failed: $failures" . "\n");
}

function quoteIfString($var)
{
	return gettype($var) == 'string' ? "'" . $var . "'" : $var;
}