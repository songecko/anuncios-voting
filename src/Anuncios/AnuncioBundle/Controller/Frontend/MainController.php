<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Voting;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
	public function indexAction()
	{		
		$categories = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->findAll();
    		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:index.html.twig', array('categories' => $categories));
	}
    
    public function categoryAction($id)
    {
    	$categories = $this->getDoctrine()
    	->getRepository('AnunciosAnuncioBundle:Category')
    	->findAll();
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$anuncios = $category->getAnuncios();
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:category.html.twig', array('categories' => $categories, 'category' => $category, 'anuncios' => $anuncios));
    }
    
	public function showAction($id)
    {
    	$categories = $this->getDoctrine()
    	->getRepository('AnunciosAnuncioBundle:Category')
    	->findAll();
    	
    	$user = $this->getUser();
    	
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$category = $anuncio->getCategory();
    	$resources = $anuncio->getResources();
    	
    	$hasVoting = $manager->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:show.html.twig', array('categories' => $categories, 'anuncio' => $anuncio, 'category' => $category, 'resources' => $resources, 'hasVoting' => $hasVoting));
    }
    
    public function voteAction($id)
    {
    	$user = $this->getUser();
    	 
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);	
    	
    	$hasVoting = $manager->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	
    	if($hasVoting)
    	{
    		return $this->forward('AnunciosAnuncioBundle:Frontend/Main:show', array(
    				'id'  => $id
    		));
    	}
    	
    	$votoJurado = $anuncio->getVotoJurado() + 1;
    	$votoUsuario = $anuncio->getVotoUsuario() + 1;
    	
    	if($user->getIsJurado())
    	{
    		$anuncio->setVotoJurado($votoJurado);
    	}
    	else
    	{
    		$anuncio->setVotoUsuario($votoUsuario);
    	}
    	
    	$manager->persist($anuncio);
    	
    	$voting = new Voting();
    	$voting->setUser($user);
    	$voting->setAnuncio($anuncio);
    	
    	$manager->persist($voting);
    	
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
