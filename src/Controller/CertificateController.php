<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CertificateController
 * @package App\Controller
 */
class CertificateController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
    {
        $allCertificates = ModelFactory::get('Certificate')->list();
        $allCertificates = array_reverse($allCertificates);

        $allCourseCertifs  = array();
        $allPathCertifs    = array();
        $allDegreeCertifs  = array();

        foreach ($allCertificates as $certificate) {
            foreach ($certificate as $value) {

                switch ($value) {
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

            ModelFactory::get('Certificate')->create($this->post->getPostArray());
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

            ModelFactory::get('Certificate')->update($this->get->getGetVar('id'), $this->post->getPostArray());
            $this->cookie->createAlert('Successful modification of the selected certificate !');

            $this->redirect('admin');
        }
        $certificate = ModelFactory::get('Certificate')->read($this->get->getGetVar('id'));

        return $this->render('back/updateCertificate.twig', ['certificate' => $certificate]);
    }

    public function deleteAction()
    {
        ModelFactory::get('Course')->delete($this->get->getGetVar('id'));

        $this->cookie->createAlert('Certificate permanently deleted !');

        $this->redirect('admin');
    }
}

