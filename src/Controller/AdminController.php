<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
use Pam\Model\ModelFactory;

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
            $allProjects        = ModelFactory::get('Project')->list(null,null,1);
            $allCertificates    = ModelFactory::get('Certificate')->list(null,null,1);

            return $this->render('back/admin.twig', [
                'allProjects'       => $allProjects,
                'allCertificates'   => $allCertificates
            ]);
        }
        htmlspecialchars(Session::createAlert('You must be logged in to access the administration', 'gray'));

        $this->redirect('user!login');
    }
}
