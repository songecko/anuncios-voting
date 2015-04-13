<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Finder\Finder;

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
	
	public function patrociniosAction($request)
	{
		$links = array(
			'patrocinios/principales/publiespania.png' => 'http://www.publiesp.es/',
			'patrocinios/secundarios/correos.png' => 'http://correos.es/',
			'patrocinios/secundarios/draftfcb.png' => 'http://www.draftfcb.com/#!home',
		);
		
		$finder = new Finder();
		try {
			$finder->files()->depth('== 0')->in('patrocinios/principales');
		} catch (\Exception $e) {
			$finder = array();
		}
		
		$patrociniosPrincipales = array();
		foreach($finder as $img)
		{
			$patrociniosPrincipales[] = array(
				'link' => isset($links[$img->__toString()])?$links[$img->__toString()]:'#',
				'image' => $img
			);
		}
		
		$finder = new Finder();
		try {
			$finder->files()->depth('== 0')->in('patrocinios/secundarios');
		} catch (\Exception $e) {
			$finder = array();
		}
		
		$patrociniosSecundarios = array();
		foreach($finder as $img)
		{
			$patrociniosSecundarios[] = array(
				'link' => isset($links[$img->__toString()])?$links[$img->__toString()]:'#',
				'image' => $img
			);
		}
	
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_patrocinios.html.twig', array(
				'patrociniosPrincipales' => $patrociniosPrincipales,
				'patrociniosSecundarios' => $patrociniosSecundarios,
				'links' => $links
		));
	}
}