<?php

use Pam\Router;
// use Tracy\Debugger;

require_once '../vendor/autoload.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();

// Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$router->run();
