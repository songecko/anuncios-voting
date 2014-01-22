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
		$campaignActive = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Campaign')
			->findOneByIsActive(true);
		
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->findAll();
		
		$leftAnunciosVoteByUser = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getLeftAnunciosVoteByUser($campaignActive, $this->getUser(), 6);
		
		$lastAnunciosVoteByUser = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getLastAnunciosVoteByUser($campaignActive, $this->getUser(), 5);
		
		foreach($categories as $category)
		{
			$rankingJurado[] = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAnunciosVoteByJurado($campaignActive, $category);
			
			$rankingUsuario[] = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAnunciosVoteByUsuario($campaignActive, $category);
		}
		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:index.html.twig', array(
    			'leftAnunciosVoteByUser'    => $leftAnunciosVoteByUser,
    			'lastAnunciosVoteByUser'    => $lastAnunciosVoteByUser,
    			'rankingJurado'             => $rankingJurado,
    			'rankingUsuario'            => $rankingUsuario
    	));
	}
    
    public function categoryAction($id)
    {
    	$campaignActive = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->findOneByIsActive(true);
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$anuncios = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAnunciosByCategory($campaignActive, $category);
    	
    	$lastAnunciosVoteByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getLastAnunciosVoteByCategory($campaignActive, $category, 5);
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:category.html.twig', array(
    			'category'                   => $category, 
    			'anuncios'                   => $anuncios,
    			'lastAnunciosVoteByCategory' => $lastAnunciosVoteByCategory
    	));
    }
    
	public function showAction($id)
    {
    	$user = $this->getUser();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$category = $anuncio->getCategory();
    	$resources = $anuncio->getResources();
    	
    	$campaignActive = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->findOneByIsActive(true);
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());

    	$hasVotingByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:User')
    		->hasVotingByCategory($campaignActive, $category);
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:show.html.twig', array(
    			'anuncio'             => $anuncio, 
    			'category'            => $category, 
    			'resources'           => $resources, 
    			'hasVoting'           => $hasVoting,
    			'hasVotingByCategory' => $hasVotingByCategory
    	));
    }
    
    public function voteAction($id)
    {
    	$user = $this->getUser();
    	 
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);	
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	
    	if($hasVoting)
    	{
    		return $this->redirect($this->generateUrl('anuncios_anuncio_show', array(
    				'id'  => $id
    		)));
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
    	
    	return $this->redirect($this->generateUrl('anuncios_anuncio_show', array(
    				'id'  => $id
    	)));
    }
    
    public function desvoteAction($id)
    {
    	$user = $this->getUser();
    	
    	$manager = $this->getDoctrine()->getManager();
    	 
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	 
    	if(!$hasVoting)
    	{
    		return $this->redirect($this->generateUrl('anuncios_anuncio_show', array(
    				'id'  => $id
    		)));
    	}
    	
    	$votoJurado = $anuncio->getVotoJurado() - 1;
    	$votoUsuario = $anuncio->getVotoUsuario() - 1;
    	
    	if($user->getIsJurado())
    	{
    		$anuncio->setVotoJurado($votoJurado);
    	}
    	else
    	{
    		$anuncio->setVotoUsuario($votoUsuario);
    	}
    	
    	$manager->persist($anuncio);
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->findOneBy(array('user'=>$user->getId(), 'anuncio'=>$anuncio->getId()));
    	
    	$manager->remove($hasVoting);
    	
    	$manager->flush();
    	
    	$this->get('session')->getFlashBag()->add(
    			'notice',
    			'Se ha desvotado correctamente.'
    	);
    	 
    	return $this->redirect($this->generateUrl('anuncios_anuncio_show', array(
    				'id'  => $id
    	)));
    }
    
    public function rankingJuradoAction($id)
    {
    	$campaignActive = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->findOneByIsActive(true);
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$rankingJurado = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAllAnunciosVoteByJurado($campaignActive, $category);
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:rankingJurado.html.twig', array(
    			'category'      => $category,
    			'rankingJurado' => $rankingJurado
    	));
    }
    
    public function rankingUsuarioAction($id)
    {
    	$campaignActive = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->findOneByIsActive(true);
    	 
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	 
    	$rankingUsuario = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAllAnunciosVoteByUsuario($campaignActive, $category);
    	 
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:rankingUsuario.html.twig', array(
    			'category'       => $category,
    			'rankingUsuario' => $rankingUsuario
    	));
    }
}
