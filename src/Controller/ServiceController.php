<?php

namespace App\Controller;

use Pam\Controller\Controller;

class ServiceController extends Controller
{
    public function indexAction()
    {
        return $this->render('front/service.twig');
    }
}
