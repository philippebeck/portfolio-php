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
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function indexAction()
    {
        $allProjects = ModelFactory::get('Project')->list();
        $allProjects = array_reverse($allProjects);

        $allToolProjects    = array();
        $allWebsiteProjects = array();

        foreach ($allProjects as $project) {
            foreach ($project as $value) {

                switch ($value) {
                    case 'tool':
                        $allToolProjects[] = $project;
                        break;
                    case 'website':
                        $allWebsiteProjects[] = $project;
                        break;
                }
            }
        }

        return $this->render('front/project.twig', [
            'allToolProjects'       => $allToolProjects,
            'allWebsiteProjects'    => $allWebsiteProjects
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

            $data['image']          = $this->files->uploadFile('img/projects');
            $data['name']           = $this->post->getPostVar('name');
            $data['link']           = $this->post->getPostVar('link');
            $data['year']           = $this->post->getPostVar('year');
            $data['project_type']   = $this->post->getPostVar('project_type');
            $data['description']    = $this->post->getPostVar('description');

            ModelFactory::get('Project')->create($data);
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
                $data['image'] = $this->files->uploadFile('img/projects');
            }

            $data['name']           = $this->post->getPostVar('name');
            $data['link']           = $this->post->getPostVar('link');
            $data['year']           = $this->post->getPostVar('year');
            $data['project_type']   = $this->post->getPostVar('project_type');
            $data['description']    = $this->post->getPostVar('description');

            ModelFactory::get('Project')->update($this->get->getGetVar('id'), $data);
            $this->cookie->createAlert('Successful modification of the selected project !');

            $this->redirect('admin');
        }
        $project = ModelFactory::get('Project')->read($this->get->getGetVar('id'));

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteAction()
    {
        ModelFactory::get('Project')->delete($this->get->getGetVar('id'));
        $this->cookie->createAlert('Project actually deleted !');

        $this->redirect('admin');
    }
}
