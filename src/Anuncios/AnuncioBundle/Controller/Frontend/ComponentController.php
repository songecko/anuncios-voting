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
		$id = $request->get('id');
		
		if(!$id)
		{
			$anuncio_id = $request->get('anuncio_id');
			if($anuncio_id)
			{
				$anuncio = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->find($anuncio_id);
				
				$id = $anuncio->getCategory()->getId();
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
		if(!$categories) 
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
			->getAnunciosVoteByJurado($activeCampaign, $category);
				
			$rankingUsuario[] = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Anuncio')
			->getAnunciosVoteByUsuario($activeCampaign, $category);
		}
		
		return $this->render('AnunciosAnuncioBundle:Frontend/Component:_rankingPreview.html.twig', array(
			'rankingJurado' => $rankingJurado,
			'rankingUsuario' => $rankingUsuario
		));
	}
}