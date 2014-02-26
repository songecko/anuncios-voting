<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Voting;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BaseFrontendController
{	
	public function indexAction()
	{
		$campaignActive = $this->getActiveCampaign();
		
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
		
		$lastAnunciosVoteByUser = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getLastAnunciosVoteByUser($campaignActive, $this->getUser(), 5);
		
		$leftAnunciosVoteByUser = array();
		
		foreach($categories as $category)
		{
			$hasVotingByCategory = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:User')
				->isCompleteVoting($campaignActive, $category, $this->getUser());
			
			if($hasVotingByCategory == false)
			{
				$leftAnunciosVoteByUser[] = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->getLeftAnunciosVoteByUser($campaignActive, $this->getUser(), $category);
			}
		}
		$leftAnunciosVoteByUser = array_filter($leftAnunciosVoteByUser);
		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:index.html.twig', array(
    			'activeCampaign'            => $campaignActive,
    			'leftAnunciosVoteByUser'    => $leftAnunciosVoteByUser,
    			'lastAnunciosVoteByUser'    => $lastAnunciosVoteByUser,
    			'categories'                => $categories
    	));
	}
    
    public function categoryAction($id)
    {
    	$user = $this->getUser();
    	
    	$campaignActive = $this->getActiveCampaign();
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	if($category->getIsAnual())
    	{
    		$anuncios = $this->getDoctrine()
    			->getRepository('AnunciosAnuncioBundle:Anuncio')
    			->getAnunciosByCategoryAnual($category, date('Y'));
    	}
    	else
    	{
	    	$anuncios = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:Anuncio')
	    		->getAnunciosByCategory($campaignActive, $category);
    	}
    	
    	$lastAnunciosVoteByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getLastAnunciosVoteByCategory($campaignActive, $category, 5);
    	
    	$hasVotingByCategory = array();
    	
    	if($user)
    	{
	    	$hasVotingByCategory = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:User')
	    		->isCompleteVoting($campaignActive, $category, $user->getId());
    	}
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:category.html.twig', array(
    			'category'                   => $category, 
    			'anuncios'                   => $anuncios,
    			'lastAnunciosVoteByCategory' => $lastAnunciosVoteByCategory,
    			'hasVotingByCategory'        => $hasVotingByCategory
    	));
    }
    
	public function showAction($anuncio_id)
    {
    	$user = $this->getUser();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($anuncio_id);
    	
    	$category = $anuncio->getCategory();
    	$resources = $anuncio->getResources();
    	
    	$campaignActive = $this->getActiveCampaign();
    	
    	$hasVoting = $hasVotingByCategory = false;
    	
    	if($user)
    	{
	    	$hasVoting = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:Voting')
	    		->hasVoting($user->getId(), $anuncio->getId());
	
	    	$hasVotingByCategory = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:User')
	    		->isCompleteVoting($campaignActive, $category, $user->getId());
    	}
    	    	
    	$externalResource = null;
    	
    	foreach($resources as $resource)
    	{
    		if($resource->getType() == 'External')
    		{
    			$externalResource = $resource;
    		}
    	}
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:show.html.twig', array(
    			'anuncio'             => $anuncio, 
    			'category'            => $category, 
    			'resources'           => $resources, 
    			'hasVoting'           => $hasVoting,
    			'hasVotingByCategory' => $hasVotingByCategory,
    			'externalResource'    => $externalResource
    	));
    }
    
    public function voteAction($id)
    {
    	$user = $this->getUser();
    	 
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);	
    	
    	$category = $anuncio->getCategory();
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	
    	$campaignActive = $this->getActiveCampaign();
    	
    	$hasVotingByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:User')
    		->isCompleteVoting($campaignActive, $category, $user->getId());
    	
    	if($hasVoting || $hasVotingByCategory || $category->getIsAnual())
    	{
    		return $this->redirect($this->generateUrl('anuncios_anuncio_show', array(
    				'slug' => $category->getSlug(),
    				'anuncio_id'  => $id
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
    				'slug' => $category->getSlug(),
    				'anuncio_id'  => $id
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
    				'slug' => $anuncio->getCategory()->getSlug(),
    				'anuncio_id'  => $id
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
    				'slug' => $anuncio->getCategory()->getSlug(),
    				'anuncio_id'  => $id
    	)));
    }
    
    public function rankingJuradoAction($id)
    {
    	$campaignActive = $this->getActiveCampaign();
    	
    	$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	
    	$rankingAnuncios = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAllAnunciosVoteByJurado($campaignActive, $category);
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:rankingJurado.html.twig', array(
    			'activeCampaign' => $campaignActive,
    			'categories'     => $categories,
    			'category'       => $category,
    			'rankingAnuncios' => $rankingAnuncios,
    			'route'          => 'anuncios_anuncio_ranking_jurado',
    			'rankingTitle'   => 'Voto del Jurado'
    	));
    }
    
    public function rankingUsuarioAction($id)
    {
    	$campaignActive = $this->getActiveCampaign();
    	 
    	$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
    	
    	$category = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->find($id);
    	 
    	$rankingAnuncios = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAllAnunciosVoteByUsuario($campaignActive, $category);
    	 
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:rankingUsuario.html.twig', array(
    			'activeCampaign' => $campaignActive,
    			'categories'     => $categories,
    			'category'       => $category,
    			'rankingAnuncios' => $rankingAnuncios,
    			'route'          => 'anuncios_anuncio_ranking_usuario',
    			'rankingTitle'   => 'Voto Popular'
    	));
    }	
    
    public function showResourceAction($resourceLink)
    {    	 
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:showResource.html.twig', array(
    			'resourceLink' => urldecode($resourceLink)
    	));
    }
}
