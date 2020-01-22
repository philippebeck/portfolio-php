<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PenController
 * @package App\Controller
 */
class PenController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        $allPens = ModelFactory::getModel('Pen')->listData();
        $allPens = array_reverse($allPens);

        $allAnimadioPens    = array();
        $allPersoPens       = array();

        foreach ($allPens as $pen) {
            switch ($pen['category']) {
                case 'animadio':
                    $allAnimadioPens[] = $pen;
                    break;
                case 'perso':
                    $allPersoPens[] = $pen;
                    break;
            }
        }

        return $this->render('front/pen.twig', [
            'allAnimadioPens'   => $allAnimadioPens,
            'allPersoPens'      => $allPersoPens
        ]);
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

            ModelFactory::getModel('Pen')->createData($this->post->getPostArray());
            $this->cookie->createAlert('New pen successfully created !');

            $this->redirect('admin');
        }

        return $this->render('back/createPen.twig');
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

            ModelFactory::getModel('Pen')->updateData($this->get->getGetVar('id'), $this->post->getPostArray());
            $this->cookie->createAlert('Successful modification of the selected pen !');

            $this->redirect('admin');
        }
        $pen = ModelFactory::getModel('Pen')->readData($this->get->getGetVar('id'));

        return $this->render('back/updatePen.twig', ['pen' => $pen]);
    }

    public function deleteMethod()
    {
        ModelFactory::getModel('Pen')->deleteData($this->get->getGetVar('id'));
        $this->cookie->createAlert('Pen permanently deleted !');

        $this->redirect('admin');
    }
}

