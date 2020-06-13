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
        if (!empty($this->getPost()->getPostArray())) {
            $image["image"] = "img/convert/convert" . $this->getFiles()->setFileExtension();

            $image["type"]  = $this->getPost()->getPostVar("type");
            $image["width"] = $this->getPost()->getPostVar("width");

            $this->service->getString()->cleanString($this->getFiles()->uploadFile("img/convert/", "convert"));

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
