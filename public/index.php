<?php

use Pam\Router;
use Tracy\Debugger;

require_once '../vendor/autoload.php';
require_once '../config/parameters.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

Debugger::enable();

$router = new Router();
$router->run();
