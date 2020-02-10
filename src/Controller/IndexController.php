<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    /**
     * @Route("/", name="index")
     * @Route("/{route}", requirements={"route"="^((?!api).)*$"})
     */
    public function index()
    {
        return $this->render('app.html.twig');
    }
}
