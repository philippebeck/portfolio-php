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
    public function loginAction()
    {
        if (!empty($this->post->getPostArray())) {
            $user = ModelFactory::getModel('User')->readData($this->post->getPostVar('email'), 'email');

            if (password_verify($this->post->getPostVar('pass'), $user['pass'])) {
                $this->session->createSession(
                    $user['id'],
                    $user['name'],
                    $user['image'],
                    $user['email']
                );

                $this->cookie->createAlert('Successful authentication, welcome ' . $user['name'] . ' !');

                $this->redirect('admin');
            }
            $this->cookie->createAlert('Failed authentication !');
        }
        return $this->render('back/login.twig');
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

            $user['name']   = $this->post->getPostVar('name');
            $user['email']  = $this->post->getPostVar('email');

            if (!empty($this->files->getFileVar('name'))) {
                $user['image'] = $this->files->uploadFile('img/user');
            }

            if (!empty($this->post->getPostVar('pass'))) {
                $user['pass'] = password_hash($this->post->getPostVar('pass'), PASSWORD_DEFAULT);
            }

            ModelFactory::getModel('User')->updateData('1', $user);
            $this->cookie->createAlert('Successful modification of the user !');

            $this->redirect('admin');
        }
        $user = ModelFactory::getModel('User')->readData('1');

        return $this->render('back/updateUser.twig', ['user' => $user]);
    }

    public function logoutAction()
    {
        $this->session->destroySession();
        $this->cookie->createAlert('Good bye !');

        $this->redirect('home');
    }
}
