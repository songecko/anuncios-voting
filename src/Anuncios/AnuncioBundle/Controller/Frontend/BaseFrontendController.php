<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseFrontendController extends Controller 
{
	protected $activeCampaign;
	
	public function setActiveCampaign($campaign)
	{
		$this->activeCampaign = $campaign;
	}
	
	public function getActiveCampaign() 
	{
		if(!$this->activeCampaign)
		{
			$this->activeCampaign = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Campaign')
				->getCampaignActive();
		}
		
		return $this->activeCampaign;
	}
}