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
        if (!empty($this->getPost()->getPostArray())) {
            $userPost = $this->getPost()->getPostArray();

            if (isset($userPost["g-recaptcha-response"]) && !empty($userPost["g-recaptcha-response"])) {

                if ($this->service->getSecurity()->checkRecaptcha($userPost["g-recaptcha-response"])) {
                    $userData = ModelFactory::getModel("User")->readData($userPost["email"], "email");

                    if (password_verify($userPost["pass"], $userData["pass"])) {
                        $this->getSession()->createSession($userData);
                        $this->getSession()->createAlert("Successful authentication, welcome " . $userData["name"] . " !", "purple");

                        $this->redirect("admin");
                    }
                    $this->getSession()->createAlert("Failed authentication !", "black");

                    $this->redirect("user");
                }
            }
            $this->getSession()->createAlert("Check the reCAPTCHA !", "red");

            $this->redirect("user");
        }
        return $this->render("front/login.twig");
    }

    private function setUpdatePassword()
    {
        $user = ModelFactory::getModel("User")->readData($this->getGet()->getGetVar("id"));

        if (!password_verify($this->getPost()->getPostVar("old-pass"), $user["pass"])) {
            $this->getSession()->createAlert("Old Password does not match !", "red");

            $this->redirect("admin");
        }

        if ($this->getPost()->getPostVar("new-pass") !== $this->getPost()->getPostVar("conf-pass")) {
            $this->getSession()->createAlert("New Passwords do not match !", "red");

            $this->redirect("admin");
        }

        $this->user["pass"] = password_hash($this->getPost()->getPostVar("new-pass"), PASSWORD_DEFAULT);
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function updateMethod()
    {
        $this->service->getSecurity()->checkAdminAccess();

        if (!empty($this->getPost()->getPostArray())) {

            $user["name"]   = $this->getPost()->getPostVar("name");
            $user["email"]  = $this->getPost()->getPostVar("email");

            if (!empty($this->getFiles()->getFileVar("name"))) {
                $user["image"] = $this->service->getString()->cleanString($user["name"]) . $this->getFiles()->setFileExtension();

                $this->getFiles()->uploadFile("img/user/", $this->service->getString()->cleanString($user["name"]));
                $this->service->getImage()->makeThumbnail("img/user/" . $user["image"], 150);
            }

            if (!empty($this->getPost()->getPostVar("pass"))) {
                $user["pass"] = password_hash($this->getPost()->getPostVar("pass"), PASSWORD_DEFAULT);
            }

            ModelFactory::getModel("User")->updateData("1", $user);
            $this->getSession()->createAlert("Successful modification of the user !", "blue");

            $this->redirect("admin");
        }
        $user = ModelFactory::getModel("User")->readData(1);

        return $this->render("back/updateUser.twig", ["user" => $user]);
    }

    public function logoutMethod()
    {
        $this->getSession()->destroySession();

        $this->redirect("home");
    }
}
