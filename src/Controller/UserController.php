<?php

namespace App\Controller;

use Pam\Controller\Controller;
use Pam\Helper\Session;
use Pam\Model\ModelFactory;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * @return string
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

            } else {
                htmlspecialchars(Session::createAlert('Failed authentication !', 'gray'));
            }
        }
        return $this->render('login.twig');
    }

    /**
     *
     */
    public function logoutAction()
    {
        Session::destroySession();

        $this->redirect('home');
    }
}
