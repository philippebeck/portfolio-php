<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ServiceController
 * @package App\Controller
 */
class ServiceController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
    {
        return $this->render('front/service.twig');
    }
}
