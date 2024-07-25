<?php

use Ordo\Database\Cli\Cli;

session_start();

define('ROOT', dirname(__FILE__));
define('SERVER_PATH', '/');

require_once ROOT . '/../../config.php';
require_once ROOT . '/../../../vendor/autoload.php';
require_once ROOT . '/../../functions.php';

$cli = new Cli($argv);
$cli->run();