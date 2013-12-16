<?php

namespace Anuncios\AnuncioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AnunciosAnuncioBundle:Default:index.html.twig', array('name' => $name));
    }
}
