<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;

/**
 * Class HomeController
 * @package App\Controller
 */
class HomeController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        $allProjects     = ModelFactory::get('Project')->list();
        $allCertificates = ModelFactory::get('Certificate')->list();

        $project     = end($allProjects);
        $certificate = end($allCertificates);

        return $this->render('home.twig', [
            'project'     => $project,
            'certificate' => $certificate
        ]);
    }
}
