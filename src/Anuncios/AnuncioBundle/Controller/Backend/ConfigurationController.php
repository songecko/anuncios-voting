<?php

namespace Anuncios\AnuncioBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anuncios\AnuncioBundle\Entity\Configuration;

/**
 * Backend configuration controller.
 *
 */
class ConfigurationController extends Controller
{
    public function indexAction()
    {   	
    	$configuration = $this->getConfiguration();
    	
    	$configurationForm = $this->createForm('anuncios_configuration', $configuration);
    	
        return $this->render('AnunciosAnuncioBundle:Backend/Configuration:index.html.twig', array(
        	'form' => $configurationForm->createView(),
        ));
    }
    
    protected function getConfiguration()
    {
    	$configuration = $this->getDoctrine()
    		->getRepository('AnunciosAnuncioBundle:Configuration')
    		->findOneBy(array());
    	
    	if(!$configuration)
    	{
    		$configuration = new Configuration();
    	}
    	
    	return $configuration;
    }
}
