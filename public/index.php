<?php

use Pam\Controller\FrontController;
use Tracy\Debugger;

require_once dirname(__DIR__).'/vendor/autoload.php';

$frontController = new FrontController();

// Basic tests area
Debugger::enable();
// print_r($_SESSION);
// var_dump($frontController);

$frontController->run();
