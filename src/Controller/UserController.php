<?php

namespace App\Controller;

use Pam\Model\Factory\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends BaseController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if (!empty($this->globals->getPost()->getPostArray())) {
            $user = ModelFactory::getModel('User')->readData($this->globals->getPost()->getPostVar('email'), 'email');

            if (password_verify($this->globals->getPost()->getPostVar('pass'), $user['pass'])) {
                $this->globals->getSession()->createSession($user);
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
        $this->checkAdminAccess();

        if (!empty($this->globals->getPost()->getPostArray())) {

            $user['name']   = $this->globals->getPost()->getPostVar('name');
            $user['email']  = $this->globals->getPost()->getPostVar('email');

            if (!empty($this->globals->getFiles()->getFileVar('name'))) {
                $user['image'] = $this->globals->getFiles()->uploadFile('img/user');
            }

            if (!empty($this->globals->getPost()->getPostVar('pass'))) {
                $user['pass'] = password_hash($this->globals->getPost()->getPostVar('pass'), PASSWORD_DEFAULT);
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
        $this->globals->getSession()->destroySession();
        $this->globals->getSession()->createAlert('Good bye !', 'purple');

        $this->redirect('home');
    }
}
