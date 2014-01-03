<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
	public function indexAction()
	{
		return $this->render('AnunciosAnuncioBundle:Frontend/Main:index.html.twig');
	}
	
    public function homeAction()
    {
    	$categories = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->findAll();
    		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:home.html.twig', array('categories' => $categories));
    }
    
    public function categoryAction($id)
    {
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$anuncios = $category->getAnuncios();
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:category.html.twig', array('category' => $category, 'anuncios' => $anuncios));
    }
    
	public function showAction($id)
    {
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$category = $anuncio->getCategory();
    	$resources = $anuncio->getResources();
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:show.html.twig', array('anuncio' => $anuncio, 'category' => $category, 'resources' => $resources));
    }
}
