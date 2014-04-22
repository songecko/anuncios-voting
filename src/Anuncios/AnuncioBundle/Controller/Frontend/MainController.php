<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Voting;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class MainController extends BaseFrontendController
{	
	public function indexAction(Request $request)
	{
		$campaignActive = $this->getActiveCampaign();
		
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->findAll();
		
		$lastAnunciosVoteByUser = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getLastAnunciosVoteByUser($campaignActive, $this->getUser(), 10);
		
		$leftAnunciosVoteByUser = array();
		$newAnunciosAnualCategory = array();
		
		foreach($categories as $category)
		{
			if(!$campaignActive->isAnual() && $category->getIsAnual())
			{
				$newAnunciosAnualCategory[] =  $this->getDoctrine()
						->getRepository('AnunciosAnuncioBundle:Anuncio')
						->getLeftAnunciosVoteByUser($campaignActive, $this->getUser(), $category);
			}else 
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
		}
		//$leftAnunciosVoteByUser = array_filter($leftAnunciosVoteByUser);
		
		//Publicidad
		$showBannerModal = true;
		if($previousBannerModalTime = $request->getSession()->get('banner_modal_time', null))
		{
			if($previousBannerModalTime > strtotime('now -1 day'))
			{
				//minus a day
				$showBannerModal = false;
			}
		}else { //first time
			$request->getSession()->set('banner_modal_time', strtotime('now'));
		}
		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:index.html.twig', array(
    			'activeCampaign'            => $campaignActive,
    			'leftAnunciosVoteByUser'    => $leftAnunciosVoteByUser,
    			'lastAnunciosVoteByUser'    => $lastAnunciosVoteByUser,
    			'newAnunciosAnualCategory' => $newAnunciosAnualCategory,
    			'categories'                => $categories,
    			'showBannerModal'           => $showBannerModal
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
    		if($campaignActive->isAnual())
    		{
    			$anuncios = $this->getDoctrine()
    				->getRepository('AnunciosAnuncioBundle:Anuncio')
    				->getAnunciosByCategory($campaignActive, $category, $campaignActive->isAnual()?$user:false);
    		}else 
    		{    			
	    		$anuncios = $this->getDoctrine()
	    			->getRepository('AnunciosAnuncioBundle:Anuncio')
	    			->getAnunciosByCategoryAnual($category, date('Y'));
    		}
    	}
    	else
    	{
	    	$anuncios = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:Anuncio')
	    		->getAnunciosByCategory($campaignActive, $category, $campaignActive->isAnual()?$user:false);
    	}
    	
    	$lastAnunciosVoteByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getLastAnunciosVoteByCategory($campaignActive, $category, 5);
    	
    	$hasVotingByCategory = array();
    	
    	if($user)
    	{
	    	$hasVotingByCategory = $this->getDoctrine()
	    		->getRepository('AnunciosAnuncioBundle:User')
	    		->isCompleteVoting($campaignActive, $category, $user);
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
	    		->isCompleteVoting($campaignActive, $category, $user);
    	}
    	    	
    	$externalResource = null;
    	
    	$auxResources = array();
    	foreach($resources as $resource)
    	{
    		if($resource->getType() == 'External' || $resource->getType() == 'Remote Resource File')
    		{
    			$externalResource = $resource;
    		}else{
    			$auxResources[] = $resource;
    		}
    	}
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:show.html.twig', array(
    			'anuncio'             => $anuncio, 
    			'category'            => $category, 
    			'resources'           => $auxResources, 
    			'hasVoting'           => $hasVoting,
    			'hasVotingByCategory' => $hasVotingByCategory,
    			'externalResource'    => $externalResource
    	));
    }
    
    public function voteAction($id)
    {
    	$user = $this->getUser();
    	$campaignActive = $this->getActiveCampaign();
    	 
    	$manager = $this->getDoctrine()->getManager();
    	
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);	
    	
    	if($anuncio->getCampaign()->getId() != $campaignActive->getId())
    		throw $this->createNotFoundException();
    	
    	$category = $anuncio->getCategory();
    	
    	$hasVoting = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->hasVoting($user->getId(), $anuncio->getId());
    	
    	$hasVotingByCategory = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:User')
    		->isCompleteVoting($campaignActive, $category, $user);
    	
    	if($hasVoting || $hasVotingByCategory || ($category->getIsAnual() && !$campaignActive->isAnual()))
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
    	$campaignActive = $this->getActiveCampaign();
    	
    	$manager = $this->getDoctrine()->getManager();
    	 
    	$anuncio = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->find($id);
    	
    	if($anuncio->getCampaign()->getId() != $campaignActive->getId())
    		throw $this->createNotFoundException();
    	
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
    		->getAllAnunciosVoteByJurado($campaignActive, $category, $campaignActive->isAnual()?$this->getUser():false);
    	
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
    		->getAllAnunciosVoteByUsuario($campaignActive, $category, $campaignActive->isAnual()?$this->getUser():false);
    	 
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:rankingUsuario.html.twig', array(
    			'activeCampaign' => $campaignActive,
    			'categories'     => $categories,
    			'category'       => $category,
    			'rankingAnuncios' => $rankingAnuncios,
    			'route'          => 'anuncios_anuncio_ranking_usuario',
    			'rankingTitle'   => 'Voto Popular'
    	));
    }	
    
    public function finalistsAction($month)
    {
    	$campaign = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->getCampaignWithMonthAndYear($month, date("Y"));
    	
    	$categories = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->getCategoriesWithoutAnual();
    	
    	$finalistasUsuario = array();
    	$finalistasJurado = array();
    	
    	foreach($categories as $category)
    	{
    		$finalistasJurado[] = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAnunciosVoteByJurado($campaign, $category);
    	
    		$finalistasUsuario[] = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Anuncio')
    		->getAnunciosVoteByUsuario($campaign, $category);
    	}
    	
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:finalists.html.twig', array(
    			'campaign'   => $campaign,
    			'categories'     => $categories,
    			'finalistasUsuario' => $finalistasUsuario,
    			'finalistasJurado'  => $finalistasJurado
    	));
    }
    
    public function showResourceAction($resourceLink)
    {    	 
    	return $this->render('AnunciosAnuncioBundle:Frontend/Main:showResource.html.twig', array(
    			'resourceLink' => urldecode($resourceLink)
    	));
    }
}
