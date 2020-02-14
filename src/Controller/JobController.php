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
        if (!empty($this->post->getPostArray())) {

            $data           = $this->post->getPostArray();
            $data['logo']   = $this->files->uploadFile('img/jobs');

            ModelFactory::getModel('Job')->createData($data);
            $this->cookie->createAlert('New job successfully created !');

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
        if (!empty($this->post->getPostArray())) {
            $data = $this->post->getPostArray();

            if (!empty($this->files->getFileVar('name'))) {
                $data['logo'] = $this->files->uploadFile('img/jobs');
            }

            ModelFactory::getModel('Job')->updateData($this->get->getGetVar('id'), $data);
            $this->cookie->createAlert('Successful modification of the selected job !');

            $this->redirect('admin');
        }
        $job = ModelFactory::getModel('Job')->readData($this->get->getGetVar('id'));

        return $this->render('back/updateJob.twig', ['job' => $job]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Job')->deleteData($this->get->getGetVar('id'));
        $this->cookie->createAlert('Job permanently deleted !');

        $this->redirect('admin');
    }
}