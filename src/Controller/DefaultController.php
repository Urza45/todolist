<?php

namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{

    /**
     * indexAction
     * 
     * @Route("/", name="homepage")
     *
     * @return void
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig');
    }
}
