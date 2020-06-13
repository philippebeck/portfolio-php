<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class JobController
 * @package App\Controller
 */
class JobController extends MainController
{
    /**
     * @var array
     */
    private $job = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $jobs = ModelFactory::getModel("Job")->listData();

        return $this->render("front/job.twig", ["jobs"  =>  $jobs]);
    }

    private function setJobLink()
    {
        $this->job["company_link"]  = str_replace("https://", "", $this->job["company_link"]);
        $this->job["project_link"]  = str_replace("https://", "", $this->job["project_link"]);
    }

    private function setJobLogo()
    {
        $this->job["logo"] = $this->service->getString()->cleanString($this->job["company"]) . $this->getFiles()->setFileExtension();

        $this->getFiles()->uploadFile("img/jobs/", $this->service->getString()->cleanString($this->job["company"]));
        $this->service->getImage()->makeThumbnail("img/jobs/" . $this->job["logo"], 100);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        $this->service->getSecurity()->checkAdminAccess();

        if (!empty($this->getPost()->getPostArray())) {

            $this->job = $this->getPost()->getPostArray();
            $this->setJobLink();
            $this->setJobLogo();

            ModelFactory::getModel("Job")->createData($this->job);
            $this->getSession()->createAlert("New job successfully created !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/createJob.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        $this->service->getSecurity()->checkAdminAccess();

        if (!empty($this->getPost()->getPostArray())) {
            $this->job = $this->getPost()->getPostArray();

            $this->setJobLink();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setJobLogo();
            }

            ModelFactory::getModel("Job")->updateData($this->getGet()->getGetVar("id"), $this->job);
            $this->getSession()->createAlert("Successful modification of the selected job !", "blue");

            $this->redirect("admin");
        }
        $job = ModelFactory::getModel("Job")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/updateJob.twig", ["job" => $job]);
    }

    public function deleteMethod()
    {
        $this->service->getSecurity()->checkAdminAccess();

        ModelFactory::getModel("Job")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Job permanently deleted !", "red");

        $this->redirect("admin");
    }
}