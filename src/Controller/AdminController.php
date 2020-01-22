<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->session->islogged()) {

            $allProjects        = ModelFactory::getModel('Project')->listData();
            $allPens            = ModelFactory::getModel('Pen')->listData();
            $allCertificates    = ModelFactory::getModel('Certificate')->listData();
            $allUsers           = ModelFactory::getModel('User')->listData();

            $allProjects        = array_reverse($allProjects);
            $allPens            = array_reverse($allPens);
            $allCertificates    = array_reverse($allCertificates);

            return $this->render('back/admin.twig', [
                'allProjects'       => $allProjects,
                'allPens'           => $allPens,
                'allCertificates'   => $allCertificates,
                'allUsers'          => $allUsers
            ]);
        }
        $this->cookie->createAlert('You must be logged in to access the administration');

        $this->redirect('user!login');
    }
}

