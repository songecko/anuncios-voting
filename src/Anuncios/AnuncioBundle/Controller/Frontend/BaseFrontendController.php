<?php

namespace Anuncios\AnuncioBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseFrontendController extends Controller 
{
	protected $activeCampaign;
	protected $configuration;
	
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
	
	public function setConfiguration($configuration)
	{
		$this->configuration = $configuration;
	}
	
	public function getConfiguration()
	{
		if(!$this->configuration)
		{
			$this->configuration = $this->getDoctrine()
            	->getRepository('AnunciosAnuncioBundle:Configuration')
            	->findOneBy(array());
		}
	
		return $this->configuration;
	}
}