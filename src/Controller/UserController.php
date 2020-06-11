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
     * @var array
     */
    private $user = [];

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if (!empty($this->globals->getPost()->getPostArray())) {
            $userPost = $this->globals->getPost()->getPostArray();

            if (isset($userPost['g-recaptcha-response']) && !empty($userPost['g-recaptcha-response'])) {

                if ($this->checkRecaptcha($userPost['g-recaptcha-response'])) {
                    $userData = ModelFactory::getModel('User')->readData($userPost['email'], 'email');

                    if (password_verify($userPost['pass'], $userData['pass'])) {
                        $this->globals->getSession()->createSession($userData);
                        $this->globals->getSession()->createAlert('Successful authentication, welcome ' . $userData['name'] . ' !', 'purple');

                        $this->redirect('admin');
                    }
                    $this->globals->getSession()->createAlert('Failed authentication !', 'black');

                    $this->redirect('user');
                }
            }
            $this->globals->getSession()->createAlert('Check the reCAPTCHA !', 'red');

            $this->redirect('user');
        }
        return $this->render('front/login.twig');
    }

    private function setUpdatePassword()
    {
        $user = ModelFactory::getModel("User")->readData($this->globals->getGet()->getGetVar("id"));

        if (!password_verify($this->globals->getPost()->getPostVar("old-pass"), $user["pass"])) {
            $this->globals->getSession()->createAlert("Old Password does not match !", "red");

            $this->redirect("admin");
        }

        if ($this->globals->getPost()->getPostVar("new-pass") !== $this->globals->getPost()->getPostVar("conf-pass")) {
            $this->globals->getSession()->createAlert("New Passwords do not match !", "red");

            $this->redirect("admin");
        }

        $this->user["pass"] = password_hash($this->globals->getPost()->getPostVar("new-pass"), PASSWORD_DEFAULT);
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
                $user["image"] = $this->cleanString($user["name"]) . $this->globals->getFiles()->setFileExtension();

                $this->globals->getFiles()->uploadFile("img/user/", $this->cleanString($user["name"]));
                $this->globals->getFiles()->makeThumbnail("img/user/" . $user["image"], 150);
            }

            if (!empty($this->globals->getPost()->getPostVar('pass'))) {
                $user['pass'] = password_hash($this->globals->getPost()->getPostVar('pass'), PASSWORD_DEFAULT);
            }

            ModelFactory::getModel('User')->updateData('1', $user);
            $this->globals->getSession()->createAlert('Successful modification of the user !', 'blue');

            $this->redirect('admin');
        }
        $user = ModelFactory::getModel('User')->readData(1);

        return $this->render('back/updateUser.twig', ['user' => $user]);
    }

    public function logoutMethod()
    {
        $this->globals->getSession()->destroySession();

        $this->redirect('home');
    }
}
