<?php

namespace App\Controller;

use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class AdminController
 * @package App\Controller
 */
class AdminController extends BaseController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $this->checkAdminAccess();

        $allProjects        = ModelFactory::getModel('Project')->listData();
        $allJobs            = ModelFactory::getModel('Job')->listData();
        $allCertificates    = ModelFactory::getModel('Certificate')->listData();
        $allUsers           = ModelFactory::getModel('User')->listData();

        $allProjects        = array_reverse($allProjects);
        $allCertificates    = array_reverse($allCertificates);

        return $this->render('back/admin.twig', [
            'allProjects'       => $allProjects,
            'allJobs'           => $allJobs,
            'allCertificates'   => $allCertificates,
            'allUsers'          => $allUsers
        ]);
    }
}

