<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
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

        $allCourseCertificates  = array();
        $allPathCertificates    = array();
        $allDegreeCertificates  = array();

        foreach ($allCertificates as $certificate) {
            foreach ($certificate as $value) {

                switch ($value) {
                    case 'course':
                        $allCourseCertificates[] = $certificate;
                        break;
                    case 'path':
                        $allPathCertificates[] = $certificate;
                        break;
                    case 'degree':
                        $allDegreeCertificates[] = $certificate;
                        break;
                }
             }
        }

        return $this->render('front/certificate.twig', [
            'allCertificates'       => $allCertificates,
            'allCourseCertificates' => $allCourseCertificates,
            'allPathCertificates'   => $allPathCertificates,
            'allDegreeCertificates' => $allDegreeCertificates
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
        if (!empty($_POST)) {
            ModelFactory::get('Certificate')->create($_POST);
            htmlspecialchars(Session::createAlert('New certificate successfully created !', 'green'));

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
        $id = filter_input(INPUT_GET, 'id');

        if (!empty($_POST)) {
            ModelFactory::get('Certificate')->update($id, $_POST);
            htmlspecialchars(Session::createAlert('Successful modification of the selected certificate !', 'blue'));

            $this->redirect('admin');
        }
        $certificate = ModelFactory::get('Certificate')->read($id);

        return $this->render('back/updateCertificate.twig', ['certificate' => $certificate]);
    }

    public function deleteAction()
    {
        $id = filter_input(INPUT_GET, 'id');
        ModelFactory::get('Course')->delete($id);
        htmlspecialchars(Session::createAlert('Certificat définitivement supprimé !', 'red'));

        $this->redirect('admin');
    }
}
