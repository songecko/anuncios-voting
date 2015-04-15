<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PortadaController extends Controller
{	
	public function comingSoonAction(Request $request)
	{
		$lastCampaignClosed = $this->getDoctrine()->
			getRepository('AnunciosAnuncioBundle:Campaign')->getLastActiveCampaignClosed();
		
		if($lastCampaignClosed)
		{
			$categoryfinalists = array();
			
			if($lastCampaignClosed->getShowFinalist() == true)
			{
				$categories = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Category')
					->getCategoriesWithoutAnual();
				
				foreach($categories as $category)
				{
					$finalistsJurado = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->getAnunciosVoteByJurado($lastCampaignClosed, $category);
									
					$finalistsUsuario = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->getAnunciosVoteByUsuario($lastCampaignClosed, $category);
					
					$categoryfinalists[] = array(
						'category' => $category,
						'finalistJurado' => $finalistsJurado,
						'finalistUsuario' => $finalistsUsuario
					);
				}
			}
			
			return $this->render('AnunciosAnuncioBundle:Frontend/Portada:comingSoonNextMonth.html.twig', array(
					'lastCampaignClosed' => $lastCampaignClosed,
					'categoryFinalists' => $categoryfinalists
			));
		}
		
    	return $this->render('AnunciosAnuncioBundle:Frontend/Portada:comingSoon.html.twig', array());
	}
}
