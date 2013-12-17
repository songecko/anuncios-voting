<?php

namespace Anuncios\AnuncioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Symfony\Component\HttpFoundation\Response;

class AnuncioController extends Controller
{
    public function createAction()
    {
    	$category = new Category();
    	$category->setName('Television');
    	
    	$anuncio = new Anuncio();
    	$anuncio->setCategory($category);
    	$anuncio->setName('Tulipan');
    	$anuncio->setAgency('Compact FMRG');
    	$anuncio->setAdvertiser('Unilever');
    	$anuncio->setProduct('Margarina');
    	$anuncio->setBrand('Tulipan');
    	$anuncio->setSector('Alimentacion');
    	$anuncio->setClientContact('Baptiste Azais');
    	$anuncio->setCreativeTeam('Virgilio Ferrer y Sergi Milà');
    	$anuncio->setBusinessDirection('Roxana Gavosto');
    	$anuncio->setMediaAgency('Mindshare');
    	$anuncio->setProducer('RCR');
    	$anuncio->setDirector('Sergi Capellas');
    	$anuncio->setSoundStudio('Idea Sonora');
    	$anuncio->setPiece('Spot TV 30');
    	$anuncio->setTitle('Pasa la receta');
    	$anuncio->setImage('prueba.jpg');
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($category);
    	$em->persist($anuncio);
    	$em->flush();
    	
        return new Response('Anuncio '.$anuncio->getName().' en la categoria '.$category->getName().' creado satisfactoriamente');
    }
    
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
