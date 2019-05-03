<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
use Pam\Model\ModelFactory;

/**
 * Class ProjectController
 * @package App\Controller
 */
class ProjectController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        $allProjects = ModelFactory::get('Project')->list(null,null,1);

        return $this->render('front/project.twig', ['allProjects' => $allProjects]);
    }

    /**
     * @return string
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

        } else {
            return $this->render('back/createProject.twig');
        }
    }

    /**
     * @return string
     */
    public function updateAction()
    {
        $id = $_GET['id'];

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

            $this->redirect('back');
        }
        $project = ModelFactory::get('Project')->read($id);

        return $this->render('back/updateProject.twig', ['project' => $project]);
    }

    /**
     *
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        ModelFactory::get('Project')->delete($id);
        htmlspecialchars(Session::createAlert('Project actually deleted !', 'red'));

        $this->redirect('admin');
    }
}
