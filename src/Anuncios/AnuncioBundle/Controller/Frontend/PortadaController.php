<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PortadaController extends Controller
{	
	public function comingSoonAction(Request $request)
	{
    	return $this->render('AnunciosAnuncioBundle:Frontend/Portada:comingSoon.html.twig', array());
	}
}
