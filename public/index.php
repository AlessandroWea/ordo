<?php

use Ordo\App;

session_start();

define('ROOT', dirname(__FILE__));
define('SERVER_PATH', '/');

require_once '../src/config.php';
require_once '../vendor/autoload.php';
require_once '../src/functions.php';

require_once '../src/container_config.php';

try {
	$app = new App;

	require_once '../src/modules.php';

	$app->run();
}
catch(\Exception $e){
	echo "<h1 style='color: red; font-size: 2rem; text-decoration: underline;'>" . $e->getMessage() . "</h1>";
	echo '<h1>Not found 404</h1>';
	die;
}
