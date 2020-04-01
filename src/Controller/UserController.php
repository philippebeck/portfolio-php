<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function loginMethod()
    {
        if (!empty($this->post->getPostArray())) {
            $user = ModelFactory::getModel('User')->readData($this->post->getPostVar('email'), 'email');

            if (password_verify($this->post->getPostVar('pass'), $user['pass'])) {
                $this->session->createSession(
                $this->globals->getSession()->createAlert('Successful authentication, welcome ' . $user['name'] . ' !', 'purple');

                $this->redirect('admin');
            }
            $this->globals->getSession()->createAlert('Failed authentication !', 'black');
        }
        return $this->render('back/login.twig');
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

            $user['name']   = $this->post->getPostVar('name');
            $user['email']  = $this->post->getPostVar('email');

            if (!empty($this->files->getFileVar('name'))) {
                $user['image'] = $this->files->uploadFile('img/user');
            }

            if (!empty($this->post->getPostVar('pass'))) {
                $user['pass'] = password_hash($this->post->getPostVar('pass'), PASSWORD_DEFAULT);
            }

            ModelFactory::getModel('User')->updateData('1', $user);
            $this->globals->getSession()->createAlert('Successful modification of the user !', 'blue');

            $this->redirect('admin');
        }
        $user = ModelFactory::getModel('User')->readData('1');

        return $this->render('back/updateUser.twig', ['user' => $user]);
    }

    public function logoutMethod()
    {
        $this->session->destroySession();
        $this->globals->getSession()->createAlert('Good bye !', 'purple');

        $this->redirect('home');
    }
}
