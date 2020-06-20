<?php

namespace App\Controller;

use Pam\Controller\MainController;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ToolController
 * @package App\Controller
 */
class ToolController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function defaultMethod()
    {
        if ($this->service->getSecurity()->checkIsAdmin() !== true) {
            $this->redirect("home");
        }

        if (!empty($this->getPost()->getPostArray())) {
            $image["image"] = $this->getFiles()->getFileVar("tmp_name");

            $image["type"]  = $this->getPost()->getPostVar("type");
            $image["width"] = $this->getPost()->getPostVar("width");

            if ($image["type"] !== "") {
                $this->service->getImage()->convertImage($image["image"], $image["type"], "img/convert/convert" . $image["type"]);
                $image["image"] = "img/convert/convert" . $image["type"];
            }

            if ($image["width"] !== "") {
                $this->service->getImage()->makeThumbnail($image["image"], $image["width"]);
            }

            return $this->render("front/tool.twig", ["image" => $image]);
        }

        return $this->render("front/tool.twig");
    }
}
