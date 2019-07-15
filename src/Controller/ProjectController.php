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
        if (!empty(filter_input_array(INPUT_POST))) {
            $data['image']          = $this->upload('img/projects');
            $data['name']           = filter_input(INPUT_POST, 'name');
            $data['link']           = filter_input(INPUT_POST, 'link');
            $data['year']           = filter_input(INPUT_POST, 'year');
            $data['project_type']   = filter_input(INPUT_POST, 'project_type');
            $data['description']    = filter_input(INPUT_POST, 'description');

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
        $id = filter_input(INPUT_GET, 'id');

        if (!empty(filter_input_array(INPUT_POST))) {
            if (!empty($_FILES['file']['name'])) {
                $data['image'] = $this->upload('img/projects');
            }
            $data['name']           = filter_input(INPUT_POST, 'name');
            $data['link']           = filter_input(INPUT_POST, 'link');
            $data['year']           = filter_input(INPUT_POST, 'year');
            $data['project_type']   = filter_input(INPUT_POST, 'project_type');
            $data['description']    = filter_input(INPUT_POST, 'description');

            ModelFactory::get('Project')->update($id, $data);
            $this->cookie->createAlert('Successful modification of the selected project !');

            $this->redirect('admin');
        }
        $project = ModelFactory::get('Project')->read($id);

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteAction()
    {
        $id = filter_input(INPUT_GET, 'id');
        ModelFactory::get('Project')->delete($id);
        $this->cookie->createAlert('Project actually deleted !');

        $this->redirect('admin');
    }
}
