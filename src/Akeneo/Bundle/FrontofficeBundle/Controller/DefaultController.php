<?php

namespace Akeneo\Bundle\FrontofficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AkeneoFrontofficeBundle:Default:index.html.twig', array('name' => $name));
    }
}
