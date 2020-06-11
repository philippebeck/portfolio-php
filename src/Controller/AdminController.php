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
        $this->checkAdminAccess();

        $projects       = ModelFactory::getModel("Project")->listData();
        $jobs           = ModelFactory::getModel("Job")->listData();
        $certificates   = ModelFactory::getModel("Certificate")->listData();
        $users          = ModelFactory::getModel("User")->listData();

        $projects       = array_reverse($projects);
        $certificates   = array_reverse($certificates);

        return $this->render("back/admin.twig", [
            "projects"      => $projects,
            "jobs"          => $jobs,
            "certificates"  => $certificates,
            "users"         => $users
        ]);
    }
}

