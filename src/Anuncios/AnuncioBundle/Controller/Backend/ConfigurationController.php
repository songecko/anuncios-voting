<?php

namespace Anuncios\AnuncioBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Configuration;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Backend configuration controller.
 *
 */
class ConfigurationController extends ResourceController
{
    public function indexAction(Request $request)
    {   	
    	$configuration = $this->getConfigurationObject();    	
    	$configurationForm = $this->getForm($configuration);
    	
        return $this->render('AnunciosAnuncioBundle:Backend/Configuration:index.html.twig', array(
        	'form' => $configurationForm->createView(),
        ));
    }
    
    public function updateAction(Request $request)
    {
    	$configuration = $this->getConfigurationObject();    	
    	$configurationForm = $this->getForm($configuration);
    
    	if ($request->isMethod('POST') && $configurationForm->bind($request)->isValid()) 
    	{
    		if($configuration->getId())
    		{
	    		$event = $this->update($configuration);
    		}else
    		{
	    		$event = $this->create($configuration);
    		}
    		
            if (!$event->isStopped()) {
                $this->setFlash('success', 'update');
            }
    	}
        
    	return $this->redirectTo($configuration);
    }
    
    protected function getConfigurationObject()
    {
    	$configuration = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Configuration')
    		->findOneBy(array());
    	
    	if(!$configuration)
    	{
    		$configuration = $this->createNew();
    	}
    	
    	return $configuration;
    }
}
