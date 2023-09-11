<?php

use Ordo\App;

session_start();

define('ROOT', dirname(__FILE__));
define('SERVER_PATH', '/');

require_once '../src/config.php';
require_once '../vendor/autoload.php';
require_once '../src/functions.php';

$app = new App;
$app->run();