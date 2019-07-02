<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Model\ModelFactory;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function loginAction()
    {
        if (!empty(filter_input_array(INPUT_POST))) {
            $user = ModelFactory::get('User')->read(filter_input(INPUT_POST, 'email'), 'email');

            if (password_verify(filter_input(INPUT_POST, 'pass'), $user['pass'])) {
                $this->session->createSession(
                    $user['id'],
                    $user['name'],
                    $user['image'],
                    $user['email']
                );

                $this->cookie->createAlert('Successful authentication, welcome ' . $user['name'] .' !');

                $this->redirect('admin');
            }
            $this->cookie->createAlert('Failed authentication !');
        }
        return $this->render('back/login.twig');
    }

    public function logoutAction()
    {
        $this->session->destroySession();

        $this->redirect('home');
    }
}
