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
        $this->data['name']         = $this->post->getPostVar('name');
        $this->data['link']         = $this->post->getPostVar('link');
        $this->data['year']         = $this->post->getPostVar('year');
        $this->data['category']     = $this->post->getPostVar('category');
        $this->data['description']  = $this->post->getPostVar('description');
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
            $data = $this->globals->getPost()->getPostArray();
            $this->postMethod();

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
        if (!empty($this->globals->getPost()->getPostArray())) {
            $data = $this->globals->getPost()->getPostArray();

            if (!empty($this->files->getFileVar('name'))) {
                $this->data['image'] = $this->files->uploadFile('img/projects');
            }
            $this->postMethod();

            ModelFactory::getModel('Project')->updateData($this->globals->getGet()->getGetVar('id'), $data);
            $this->globals->getSession()->createAlert('Successful modification of the selected project !', 'blue');

            $this->redirect('admin');
        }
        $project = ModelFactory::getModel('Project')->readData($this->globals->getGet()->getGetVar('id'));

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Project')->deleteData($this->globals->getGet()->getGetVar('id'));
        $this->globals->getSession()->createAlert('Project actually deleted !', 'red');

        $this->redirect('admin');
    }
}
