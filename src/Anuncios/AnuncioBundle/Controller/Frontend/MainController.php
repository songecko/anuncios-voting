<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
    
    public function voteAction($id)
    {
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$votoJurado = $anuncio->getVotoJurado() + 1;
    	$votoUsuario = $anuncio->getVotoUsuario() + 1;
    	
    	$anuncio->setVotoJurado($votoJurado);
    	$anuncio->setVotoUsuario($votoUsuario);
    	
    	$manager->persist($anuncio);
    	
    	$manager->flush();
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Se ha votado correctamente.'
    	);
    	
    	return $this->forward('AnunciosAnuncioBundle:Frontend/Main:show', array(
    			'id'  => $id
    	));
    }
}
