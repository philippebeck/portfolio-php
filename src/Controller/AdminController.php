<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
    {
        if ($this->session->islogged()) {
            $allProjects        = ModelFactory::get('Project')->list();
            $allCertificates    = ModelFactory::get('Certificate')->list();

            $allProjects        = array_reverse($allProjects);
            $allCertificates    = array_reverse($allCertificates);

            return $this->render('back/admin.twig', [
                'allProjects'       => $allProjects,
                'allCertificates'   => $allCertificates
            ]);
        }
        $this->cookie->createAlert('You must be logged in to access the administration');

        $this->redirect('user!login');
    }
}

