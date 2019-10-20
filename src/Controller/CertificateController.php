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
    public function indexAction()
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
    public function createAction()
    {
        if (!empty($this->post->getPostArray())) {

            ModelFactory::getModel('Certificate')->createData($this->post->getPostArray());
            $this->cookie->createAlert('New certificate successfully created !');

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
    public function updateAction()
    {
        if (!empty($this->post->getPostArray())) {

            ModelFactory::getModel('Certificate')->updateData($this->get->getGetVar('id'), $this->post->getPostArray());
            $this->cookie->createAlert('Successful modification of the selected certificate !');

            $this->redirect('admin');
        }
        $certificate = ModelFactory::getModel('Certificate')->readData($this->get->getGetVar('id'));

        return $this->render('back/updateCertificate.twig', ['certificate' => $certificate]);
    }

    public function deleteAction()
    {
        ModelFactory::getModel('Certificate')->deleteData($this->get->getGetVar('id'));
        $this->cookie->createAlert('Certificate permanently deleted !');

        $this->redirect('admin');
    }
}

