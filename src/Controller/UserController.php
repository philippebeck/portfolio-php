<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
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
        if (!empty($_POST)) {
            $user = ModelFactory::get('User')->read($_POST['email'], 'email');

            if (password_verify($_POST['pass'], $user['pass'])) {
                Session::createSession(
                    $user['id'],
                    $user['first_name'],
                    $user['image'],
                    $user['email']
                );

                htmlspecialchars(Session::createAlert('Successful authentication, welcome ' . $user['first_name'] .' !', 'purple'));

                $this->redirect('admin');
            }
            htmlspecialchars(Session::createAlert('Failed authentication !', 'gray'));
        }
        return $this->render('back/login.twig');
    }

    public function logoutAction()
    {
        Session::destroySession();

        $this->redirect('home');
    }
}
