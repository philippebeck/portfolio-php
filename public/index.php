<?php

use Pam\Controller\FrontController;
use Pam\Helper\Session;

// For Development only (needs to be comment in Production)
use Tracy\Debugger;

require_once dirname(__DIR__).'/vendor/autoload.php';

$session            = new Session();
$frontController    = new FrontController();

// For Development only (needs to be comment in Production)
Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
