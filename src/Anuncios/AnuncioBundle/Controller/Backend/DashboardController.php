<?php

namespace Anuncios\AnuncioBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Backend dashboard controller.
 *
 */
class DashboardController extends Controller
{
    /**
     * Backend dashboard display action.
     */
    public function mainAction()
    {
    	$campaign = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->getCampaignActive();
    	
    	$closed = false;
    	
    	if(!$campaign)
    	{
    		$campaign = $this->getDoctrine()
    			->getRepository('AnunciosAnuncioBundle:Campaign')
    			->getLastActiveCampaignClosed();
    		
    		$closed = true;
    	}
    	
    	if($campaign->isAnual())
    	{
    		$categories = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Category')
    		->findAll();
    	}else 
    	{
    		$categories = $this->getDoctrine()
    			->getRepository('AnunciosAnuncioBundle:Category')
    			->getCategoriesWithoutAnual();
    	}
    	
    	$rankingUsuario = array();
    	$rankingJurado = array();
    	
    	foreach($categories as $category)
    	{
    		$rankingJurado[] = $this->getDoctrine()
    			->getRepository('AnunciosAnuncioBundle:Anuncio')
    			->getAnunciosVoteByJurado($campaign, $category);
    	
    		$rankingUsuario[] = $this->getDoctrine()
    			->getRepository('AnunciosAnuncioBundle:Anuncio')
    			->getAnunciosVoteByUsuario($campaign, $category);
    	}
    	
        return $this->render('AnunciosAnuncioBundle:Backend/Dashboard:main.html.twig', array(
        	'campaign'   => $campaign,
			'rankingUsuario' => $rankingUsuario,
			'rankingJurado'  => $rankingJurado,
        	'closed'         => $closed
        ));
    }
}
