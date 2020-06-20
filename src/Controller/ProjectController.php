<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ProjectController
 * @package App\Controller
 */
class ProjectController extends MainController
{
    /**
     * @var array
     */
    private $project = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $projects = $this->service->getArray()->getArrayElements(ModelFactory::getModel("Project")->listData());

        return $this->render("front/project.twig", [
            "toolProjects"      => $projects["tool"],
            "websiteProjects"   => $projects["website"],
            "animadioPens"      => $projects["animadio"],
            "freecodecampPens"  => $projects["freecodecamp"]
        ]);
    }

    private function setProjectData()
    {
        $this->project["name"]         = $this->getPost()->getPostVar("name");
        $this->project["year"]         = $this->getPost()->getPostVar("year");
        $this->project["category"]     = $this->getPost()->getPostVar("category");
        $this->project["description"]  = $this->getPost()->getPostVar("description");

        $this->project["link"] = str_replace("https://", "", $this->getPost()->getPostVar("link"));
    }

    private function setProjectPicture() {
        $this->project["image"] = $this->service->getString()->cleanString($this->project["name"]) . $this->getFiles()->setFileExtension();

        $this->getFiles()->uploadFile("img/projects/", $this->service->getString()->cleanString($this->project["name"]));
        $this->service->getImage()->makeThumbnail("img/projects/" . $this->project["image"], 300);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if ($this->service->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setProjectData();
            $this->setProjectPicture();

            ModelFactory::getModel("Project")->createData($this->project);
            $this->getSession()->createAlert("New project created successfully !", "green");

            $this->redirect("admin");
        }

        return $this->render("back/createProject.twig");
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        if ($this->service->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $this->setProjectData();

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $this->setProjectPicture();
            }

            ModelFactory::getModel("Project")->updateData($this->getGet()->getGetVar("id"), $this->project);
            $this->getSession()->createAlert("Successful modification of the selected project !", "blue");

            $this->redirect("admin");
        }
        $project = ModelFactory::getModel("Project")->readData($this->getGet()->getGetVar("id"));

        return $this->render("back/updateProject.twig", ["project" => $project]);
    }

    public function deleteMethod()
    {
        if ($this->service->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        ModelFactory::getModel("Project")->deleteData($this->getGet()->getGetVar("id"));
        $this->getSession()->createAlert("Project actually deleted !", "red");

        $this->redirect("admin");
    }
}
