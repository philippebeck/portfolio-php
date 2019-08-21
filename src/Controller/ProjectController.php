<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ProjectController
 * @package App\Controller
 */
class ProjectController extends Controller
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
    public function indexAction()
    {
        $allProjects = ModelFactory::getModel('Project')->listData();
        $allProjects = array_reverse($allProjects);

        $allToolProjects    = array();
        $allWebsiteProjects = array();

        foreach ($allProjects as $project) {
            switch ($project['category']) {
                case 'tool':
                    $allToolProjects[] = $project;
                    break;
                case 'website':
                    $allWebsiteProjects[] = $project;
                    break;
            }
        }

        return $this->render('front/project.twig', [
            'allToolProjects'       => $allToolProjects,
            'allWebsiteProjects'    => $allWebsiteProjects
        ]);
    }

    private function postAction()
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
    public function createAction()
    {
        if (!empty($this->post->getPostArray())) {
            $this->data['image'] = $this->files->uploadFile('img/projects');
            $this->postAction();

            ModelFactory::getModel('Project')->createData($this->data);
            $this->cookie->createAlert('New project created successfully !');

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
    public function updateAction()
    {
        if (!empty($this->post->getPostArray())) {

            if (!empty($this->files->getFileVar('name'))) {
                $this->data['image'] = $this->files->uploadFile('img/projects');
            }
            $this->postAction();

            ModelFactory::getModel('Project')->updateData($this->get->getGetVar('id'), $this->data);
            $this->cookie->createAlert('Successful modification of the selected project !');

            $this->redirect('admin');
        }
        $project = ModelFactory::getModel('Project')->readData($this->get->getGetVar('id'));

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteAction()
    {
        ModelFactory::getModel('Project')->deleteData($this->get->getGetVar('id'));
        $this->cookie->createAlert('Project actually deleted !');

        $this->redirect('admin');
    }
}
