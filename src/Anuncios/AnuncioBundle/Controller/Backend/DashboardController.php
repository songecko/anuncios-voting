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
    	
    	$categories = array();
    	$rankingUsuario = array();
    	$rankingJurado = array();
    	$currentYear = (date('n')=='1')?date('Y')-1:date('Y');
    	$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    	
    	if($campaign)
    	{
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
	    	
	    	foreach($categories as $category)
	    	{
	    		$rankingJurado[] = $this->getDoctrine()
	    			->getRepository('AnunciosAnuncioBundle:Anuncio')
	    			->getAnunciosVoteByJurado($campaign, $category);
	    	
	    		$rankingUsuario[] = $this->getDoctrine()
	    			->getRepository('AnunciosAnuncioBundle:Anuncio')
	    			->getAnunciosVoteByUsuario($campaign, $category);
	    	}
    	}
    	
    	$votesOnYear = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Voting')
    		->votesOnYear($currentYear);

    	/*$finalCampaign = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Campaign')
    		->getFinalCampaignOfYear($currentYear);*/
    	
    	$votesPerMonth = array();
    	foreach ($votesOnYear as $vote)
    	{
    		$monthNumber = $vote->getAnuncio()->getCampaign()->getPeriodName();
    		    		
    		if(!isset($votesPerMonth[$monthNumber]))
    			$votesPerMonth[$monthNumber] = 0;
    		
    		$votesPerMonth[$monthNumber] = $votesPerMonth[$monthNumber]+1; 
    	}

    	/*$votesOnFinal = null;
    	if($finalCampaign)
    	{
    		$votesOnFinal = 0;
    		$monthNumber = $finalCampaign->getDateBegin()->format('n');
    		if($monthNumber != 1)
    		{
    			$month = $months[$monthNumber-1];
    			if(isset($votesPerMonth[$month]))
    			{
    				$votesOnFinal = $votesPerMonth[$month];
    				unset($votesPerMonth[$month]);
    			}
    		}
    		
    	}*/
    	
        return $this->render('AnunciosAnuncioBundle:Backend/Dashboard:main.html.twig', array(
        	'campaign'   => $campaign,
			'rankingUsuario' => $rankingUsuario,
			'rankingJurado'  => $rankingJurado,
        	'closed'         => $closed,
        	'currentYear'    => $currentYear,
        	'votesPerMonth'  => $votesPerMonth
        ));
    }
}
