<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
use Pam\Model\ModelFactory;

/**
 * Class CertificateController
 * @package App\Controller
 */
class CertificateController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        $allCertificates = ModelFactory::get('Certificate')->list(null,null,1);

        return $this->render('front/certificate.twig', ['allCertificates' => $allCertificates]);
    }

    /**
     * @return string
     */
    public function createAction()
    {
        if (!empty($_POST)) {
            ModelFactory::get('Certificate')->create($_POST);
            htmlspecialchars(Session::createAlert('Nouveau certificat créé avec succès !', 'green'));

            $this->redirect('admin');
            
        } else {
            return $this->render('back/createCertificate.twig');
        }
    }

    /**
     * @return string
     */
    public function updateAction()
    {
        $id = $_GET['id'];

        if (!empty($_POST)) {
            ModelFactory::get('Certificate')->update($id, $_POST);
            htmlspecialchars(Session::createAlert('Modification réussie du certificat sélectionné !', 'blue'));

            $this->redirect('admin');
        }
        $certificate = ModelFactory::get('Certificate')->read($id);

        return $this->render('back/updateCertificate.twig', ['certificate' => $certificate]);
    }

    /**
     *
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        ModelFactory::get('Course')->delete($id);
        htmlspecialchars(Session::createAlert('Certificat définitivement supprimé !', 'red'));

        $this->redirect('admin');
    }
}
