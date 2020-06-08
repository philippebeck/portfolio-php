<?php

namespace App\Controller;

use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ProjectController
 * @package App\Controller
 */
class ProjectController extends BaseController
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allProjects = ModelFactory::getModel('Project')->listData();
        $allProjects = array_reverse($allProjects);

        $allToolProjects        = array();
        $allWebsiteProjects     = array();
        $allAnimadioPens        = array();
        $allFreecodecampPens    = array();

        foreach ($allProjects as $project) {
            switch ($project['category']) {
                case 'tool':
                    $allToolProjects[] = $project;
                    break;
                case 'website':
                    $allWebsiteProjects[] = $project;
                    break;
                case 'animadio':
                    $allAnimadioPens[] = $project;
                    break;
                case 'freecodecamp':
                    $allFreecodecampPens[] = $project;
                    break;
            }
        }

        return $this->render('front/project.twig', [
            'allToolProjects'       => $allToolProjects,
            'allWebsiteProjects'    => $allWebsiteProjects,
            'allAnimadioPens'       => $allAnimadioPens,
            'allFreecodecampPens'   => $allFreecodecampPens
        ]);
    }

    private function postMethod()
    {
        $this->data['name']         = $this->globals->getPost()->getPostVar('name');
        $this->data['link']         = $this->globals->getPost()->getPostVar('link');
        $this->data['year']         = $this->globals->getPost()->getPostVar('year');
        $this->data['category']     = $this->globals->getPost()->getPostVar('category');
        $this->data['description']  = $this->globals->getPost()->getPostVar('description');
    }

    private function setImage() {
        $this->data['image'] = $this->globals->getFiles()->uploadFile('img/projects/', $this->data['name']);
        $this->globals->getFiles()->makeThumbnail("img/projects/" . $this->data['image'], 300);
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
            $this->postMethod();
            $this->setImage();

            ModelFactory::getModel('Project')->createData($this->data);
            $this->globals->getSession()->createAlert('New project created successfully !', 'green');

            $this->redirect('admin');
        }
        return $this->render('back/createProject.twig');
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
            $this->postMethod();

            if (!empty($this->globals->getFiles()->getFileVar('name'))) {
                $this->setImage();
            }

            ModelFactory::getModel('Project')->updateData($this->globals->getGet()->getGetVar('id'), $this->data);
            $this->globals->getSession()->createAlert('Successful modification of the selected project !', 'blue');

            $this->redirect('admin');
        }
        $project = ModelFactory::getModel('Project')->readData($this->globals->getGet()->getGetVar('id'));

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteMethod()
    {
        $this->checkAdminAccess();

        ModelFactory::getModel('Project')->deleteData($this->globals->getGet()->getGetVar('id'));
        $this->globals->getSession()->createAlert('Project actually deleted !', 'red');

        $this->redirect('admin');
    }
}
