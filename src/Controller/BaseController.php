<?php

namespace App\Controller;

use Pam\Controller\MainController;

/**
 * Class BaseController
 * @package App\Controller
 */
class BaseController extends MainController
{
    public function checkAdminAccess()
    {
        if ($this->globals->getSession()->islogged() === false) {
            $this->globals->getSession()->createAlert('You must be logged in to access the administration', 'black');

            $this->redirect('user!login');
        }
    }
}