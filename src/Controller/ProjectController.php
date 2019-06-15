<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
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
            'allProjects'           => $allProjects,
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
        if (!empty($_POST)) {
            $data['image']          = $this->upload('img/project');
            $data['name']           = $_POST['name'];
            $data['link']           = $_POST['link'];
            $data['year']           = $_POST['year'];
            $data['description']    = $_POST['description'];

            ModelFactory::get('Project')->create($data);
            htmlspecialchars(Session::createAlert('New project created successfully !', 'green'));

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

        if (!empty($_POST)) {
            if (!empty($_FILES['file']['name'])) {
                $data['image'] = $this->upload('img/project');
            }
            $data['name']         = $_POST['name'];
            $data['link']         = $_POST['link'];
            $data['year']         = $_POST['year'];
            $data['description']  = $_POST['description'];

            ModelFactory::get('Project')->update($id, $data);
            htmlspecialchars(Session::createAlert('Successful modification of the selected project !', 'blue'));

            $this->redirect('admin');
        }
        $project = ModelFactory::get('Project')->read($id);

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    public function deleteAction()
    {
        $id = filter_input(INPUT_GET, 'id');
        ModelFactory::get('Project')->delete($id);
        htmlspecialchars(Session::createAlert('Project actually deleted !', 'red'));

        $this->redirect('admin');
    }
}
