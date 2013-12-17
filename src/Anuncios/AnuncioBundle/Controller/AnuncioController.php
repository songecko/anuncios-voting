<?php

namespace Anuncios\AnuncioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class AnuncioController extends Controller
{ 
    public function indexAction()
    {
    	$categories = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->findAll();
    		
    	return $this->render('AnunciosAnuncioBundle:Anuncio:index.html.twig', array('categories' => $categories));
    }
    public function listAction($id)
    {
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$anuncios = $category->getAnuncios();
    	
    	return $this->render('AnunciosAnuncioBundle:Anuncio:list.html.twig', array('category' => $category, 'anuncios' => $anuncios));
    }
    
	public function showAction($id)
    {
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$category = $anuncio->getCategory();
    	
    	return $this->render('AnunciosAnuncioBundle:Anuncio:show.html.twig', array('anuncio' => $anuncio, 'category' => $category));
    }
}
