<?php

use Pam\Controller\FrontController;

// For Development only (needs to be comment in Production)
use Tracy\Debugger;

require_once '../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$frontController = new FrontController();

// For Development only (needs to be comment in Production)
Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
