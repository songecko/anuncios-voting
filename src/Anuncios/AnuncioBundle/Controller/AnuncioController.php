<?php

namespace Anuncios\AnuncioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Symfony\Component\HttpFoundation\Response;

class AnuncioController extends Controller
{
    public function createAction()
    {
    	$anuncio = new Anuncio();
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
    	$em->persist($anuncio);
    	$em->flush();
    	
        return new Response('Anuncio '.$anuncio->getId().' creado satisfactoriamente');
    }
    
    public function listAction()
    {
    	$anuncios = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->findAll();
    	
    	return $this->render('AnunciosAnuncioBundle:Anuncio:list.html.twig', array('anuncios' => $anuncios));
    }
    
	public function showAction($id)
    {
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	return $this->render('AnunciosAnuncioBundle:Anuncio:show.html.twig', array('anuncio' => $anuncio));
    }
}
