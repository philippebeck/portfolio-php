<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class XpController
 * @package App\Controller
 */
class XpController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allXps = ModelFactory::getModel('Xp')->listData();
        $allXps = array_reverse($allXps);

        return $this->render('front/xp.twig', ['allXps'  =>  $allXps]);
    }
}