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
     * @var array
     */
    private $certificate = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $certificates = $this->getArrayElements(ModelFactory::getModel("Certificate")->listData());

        return $this->render("front/certificate.twig", [
            "courseCertifs" => $certificates["course"],
            "pathCertifs"   => $certificates["path"],
            "degreeCertifs" => $certificates["degree"]
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
        $this->checkAdminAccess();

        if (!empty($this->globals->getPost()->getPostArray())) {
            $this->certificate          = $this->globals->getPost()->getPostArray();
            $this->certificate["link"]  = str_replace("https://", "", $this->certificate["link"]);

            ModelFactory::getModel("Certificate")->createData($this->certificate);
            $this->globals->getSession()->createAlert("New certificate successfully created !", "green");

            $this->redirect("admin");
        }
        return $this->render("back/createCertificate.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        $this->checkAdminAccess();

        if (!empty($this->globals->getPost()->getPostArray())) {
            $this->certificate          = $this->globals->getPost()->getPostArray();
            $this->certificate["link"]  = str_replace("https://", "", $this->certificate["link"]);

            ModelFactory::getModel("Certificate")->updateData($this->globals->getGet()->getGetVar("id"), $this->certificate);
            $this->globals->getSession()->createAlert("Successful modification of the selected certificate !", "blue");

            $this->redirect("admin");
        }
        $certificate = ModelFactory::getModel("Certificate")->readData($this->globals->getGet()->getGetVar("id"));

        return $this->render("back/updateCertificate.twig", ["certificate" => $certificate]);
    }

    public function deleteMethod()
    {
        $this->checkAdminAccess();

        ModelFactory::getModel("Certificate")->deleteData($this->globals->getGet()->getGetVar("id"));
        $this->globals->getSession()->createAlert("Certificate permanently deleted !", "red");

        $this->redirect("admin");

    }
}

