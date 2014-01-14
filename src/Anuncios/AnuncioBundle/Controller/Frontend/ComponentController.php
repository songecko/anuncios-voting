<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ComponentController extends Controller
{
	public function menuAction()
	{
		$categories = $this->getDoctrine()
		->getRepository('AnunciosAnuncioBundle:Category')
		->findAll();
	
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_menu.html.twig', array(
				'categories' => $categories
		));
	}
}