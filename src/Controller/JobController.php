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
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allJobs = ModelFactory::getModel('Job')->listData();

        return $this->render('front/job.twig', ['allJobs'  =>  $allJobs]);
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

            $data           = $this->globals->getPost()->getPostArray();
            $data['logo']   = $this->files->uploadFile('img/jobs');

            ModelFactory::getModel('Job')->createData($data);
            $this->globals->getSession()->createAlert('New job successfully created !', 'green');

            $this->redirect('admin');
        }

        return $this->render('back/createJob.twig');
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
                $data['logo'] = $this->files->uploadFile('img/jobs');
            }

            ModelFactory::getModel('Job')->updateData($this->globals->getGet()->getGetVar('id'), $data);
            $this->globals->getSession()->createAlert('Successful modification of the selected job !', 'blue');

            $this->redirect('admin');
        }
        $job = ModelFactory::getModel('Job')->readData($this->globals->getGet()->getGetVar('id'));

        return $this->render('back/updateJob.twig', ['job' => $job]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Job')->deleteData($this->globals->getGet()->getGetVar('id'));
        $this->globals->getSession()->createAlert('Job permanently deleted !', 'red');

        $this->redirect('admin');
    }
}