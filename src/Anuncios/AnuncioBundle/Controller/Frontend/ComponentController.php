<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ComponentController extends Controller
{
	public function menuAction($request)
	{
		$id = 0;
		
		if(in_array($request->get('_route'), array('anuncios_anuncio_category')))
		{
			$id = $request->get('id');
			
			if(!$id)
			{
				try {
					$anuncio_id = $request->get('anuncio_id');
					$anuncio = $this->getDoctrine()
						->getRepository('AnunciosAnuncioBundle:Anuncio')
						->find($anuncio_id);	
					$id = $anuncio->getCategory()->getId();
				}catch (\Exception $e)
				{}
			}
		}
		
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->findAll();
	
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_menu.html.twig', array(
				'categories' => $categories,
				'id'         => $id
		));
	}
	
	public function rankingPreviewAction($activeCampaign, $categories = null)
	{
		if(!$categories || $activeCampaign->isAnual()) 
		{
			$categories = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Category')
				->findAll();
		}
		
		$rankingJurado = array();
		$rankingUsuario = array();
		
		foreach($categories as $category)
		{
			$rankingJurado[] = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
 			->getAnunciosVoteByJurado($activeCampaign, $category, $activeCampaign->isAnual()?$this->getUser():false);
				
			$rankingUsuario[] = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getAnunciosVoteByUsuario($activeCampaign, $category, $activeCampaign->isAnual()?$this->getUser():false);
		}
		
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_rankingPreview.html.twig', array(
			'rankingJurado' => $rankingJurado,
			'rankingUsuario' => $rankingUsuario
		));
	}
	
	public function previousFinalistsAction($activeCampaign = null)
	{	
		$monthCampaigns = array();
		
		$year = ($activeCampaign)?$activeCampaign->getYear():date("Y");
		
		for ($month=1; $month <= 12; $month++)
		{
			$campaign = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Campaign')
				->getCampaignWithMonthAndYear($month, $year);
			
			$monthCampaigns[$month] = $campaign;
		} 
		
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_previousFinalists.html.twig', array(
			'monthCampaigns' => $monthCampaigns
		));
	}
	
	public function googleTagHeaderAction($request)
	{
		$googleTagTargeting = "home";
		
		if(in_array($request->get('_route'), array('anuncios_anuncio_category')))
		{
			try {
				$categoryId = $request->get('id');
				$category = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Category')
					->find($categoryId);
				$googleTagTargeting = $category->getName();
			}catch (\Exception $e)
			{}
		}else if(in_array($request->get('_route'), array('anuncios_anuncio_show')))
		{
			try {
				$anuncioId = $request->get('anuncio_id');
				$anuncio = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->find($anuncioId);
				$googleTagTargeting = $anuncio->getCategory()->getName();
			}catch (\Exception $e)
			{}
		}else if(!in_array($request->get('_route'), array('anuncios_anuncio_index')))
		{
			$googleTagTargeting = "default";
		}
		
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_googleTagHeader.html.twig', array(
				'googleTagTargeting' => $googleTagTargeting
		));
	}
}