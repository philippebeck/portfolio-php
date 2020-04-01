<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CertificateController
 * @package App\Controller
 */
class CertificateController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allCertificates = ModelFactory::getModel('Certificate')->listData();
        $allCertificates = array_reverse($allCertificates);

        $allCourseCertifs  = array();
        $allPathCertifs    = array();
        $allDegreeCertifs  = array();

        foreach ($allCertificates as $certificate) {
            switch ($certificate['category']) {
                case 'course':
                    $allCourseCertifs[] = $certificate;
                    break;
                case 'path':
                    $allPathCertifs[] = $certificate;
                    break;
                case 'degree':
                    $allDegreeCertifs[] = $certificate;
                    break;
            }
        }

        return $this->render('front/certificate.twig', [
            'allCourseCertifs' => $allCourseCertifs,
            'allPathCertifs'   => $allPathCertifs,
            'allDegreeCertifs' => $allDegreeCertifs
        ]);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if (!empty($this->globals->getPost()->getPostArray())) {

            ModelFactory::getModel('Certificate')->createData($this->globals->getPost()->getPostArray());
            $this->globals->getSession()->createAlert('New certificate successfully created !', 'green');

            $this->redirect('admin');
        }

        return $this->render('back/createCertificate.twig');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if (!empty($this->globals->getPost()->getPostArray())) {

            ModelFactory::getModel('Certificate')->updateData($this->globals->getGet()->getGetVar('id'), $this->globals->getPost()->getPostArray());
            $this->globals->getSession()->createAlert('Successful modification of the selected certificate !', 'blue');

            $this->redirect('admin');
        }
        $certificate = ModelFactory::getModel('Certificate')->readData($this->globals->getGet()->getGetVar('id'));

        return $this->render('back/updateCertificate.twig', ['certificate' => $certificate]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Certificate')->deleteData($this->globals->getGet()->getGetVar('id'));
        $this->globals->getSession()->createAlert('Certificate permanently deleted !', 'red');

        $this->redirect('admin');
    }
}

