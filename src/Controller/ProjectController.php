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
        $projects = $this->getArrayElements(ModelFactory::getModel("Project")->listData());

        return $this->render("front/project.twig", [
            "toolProjects"      => $projects["tool"],
            "websiteProjects"   => $projects["website"],
            "animadioPens"      => $projects["animadio"],
            "freecodecampPens"  => $projects["freecodecamp"]
        ]);
    }

    private function setProjectData()
    {
        $this->project["name"]         = $this->globals->getPost()->getPostVar("name");
        $this->project["year"]         = $this->globals->getPost()->getPostVar("year");
        $this->project["category"]     = $this->globals->getPost()->getPostVar("category");
        $this->project["description"]  = $this->globals->getPost()->getPostVar("description");

        $this->project["link"] = str_replace("https://", "", $this->globals->getPost()->getPostVar("link"));
    }

    private function setProjectPicture() {
        $this->project["image"] = $this->cleanString($this->project["name"]) . $this->globals->getFiles()->setFileExtension();

        $this->globals->getFiles()->uploadFile("img/projects/", $this->cleanString($this->project["name"]));
        $this->globals->getFiles()->makeThumbnail("img/projects/" . $this->project["image"], 300);
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
            $this->setProjectData();
            $this->setProjectPicture();

            ModelFactory::getModel("Project")->createData($this->project);
            $this->globals->getSession()->createAlert("New project created successfully !", "green");

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
        $this->checkAdminAccess();

        if (!empty($this->globals->getPost()->getPostArray())) {
            $this->setProjectData();

            if (!empty($this->globals->getFiles()->getFileVar("name"))) {
                $this->setProjectPicture();
            }

            ModelFactory::getModel("Project")->updateData($this->globals->getGet()->getGetVar("id"), $this->project);
            $this->globals->getSession()->createAlert("Successful modification of the selected project !", "blue");

            $this->redirect("admin");
        }
        $project = ModelFactory::getModel("Project")->readData($this->globals->getGet()->getGetVar("id"));

        return $this->render("back/updateProject.twig", ["project" => $project]);
    }

    public function deleteMethod()
    {
        $this->checkAdminAccess();

        ModelFactory::getModel("Project")->deleteData($this->globals->getGet()->getGetVar("id"));
        $this->globals->getSession()->createAlert("Project actually deleted !", "red");

        $this->redirect("admin");
    }
}
