<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
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
        if (Session::islogged()) {
            $allProjects        = ModelFactory::get('Project')->list();
            $allCertificates    = ModelFactory::get('Certificate')->list();

            $allProjects        = array_reverse($allProjects);
            $allCertificates    = array_reverse($allCertificates);

            return $this->render('back/admin.twig', [
                'allProjects'       => $allProjects,
                'allCertificates'   => $allCertificates
            ]);
        }
        htmlspecialchars(Session::createAlert('You must be logged in to access the administration', 'gray'));

        $this->redirect('user!login');
    }
}
