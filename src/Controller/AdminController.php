<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Pam\Helper\Session;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        if (Session::islogged()) {
            $allProjects        = ModelFactory::get('Project')->list();
            $allCertificates    = ModelFactory::get('Certificate')->list();

            return $this->render('admin.twig', [
                'allProjects'       => $allProjects,
                'allCertificates'   => $allCertificates
            ]);

        } else {
            htmlspecialchars(Session::createAlert('You must be logged in to access the administration', 'gray'));

            $this->redirect('user!login');
        }
    }
}
