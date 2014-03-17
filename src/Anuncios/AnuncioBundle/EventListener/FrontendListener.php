<?php

namespace Anuncios\AnuncioBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Anuncios\AnuncioBundle\Controller\Frontend\BaseFrontendController;

class FrontendListener
{
	protected $container;
	protected $resolver;
	
    public function __construct(Container $container, ControllerResolverInterface $resolver)
    {
    	$this->container = $container;
    	$this->resolver = $resolver;
    }
    
	public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        
        /*
         * $controller passed can be either a class or a Closure. This is not usual in Symfony2 but it may happen.
         * If it is a class, it comes in array format
         */
        if (!is_array($controller)) {
            return;
        }

        $controller = $controller[0];
        if ($controller instanceof BaseFrontendController) {
            $activeCampaign = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Campaign')
				->getCampaignActive();
            $configuration = $this->getDoctrine()
            	->getRepository('AnunciosAnuncioBundle:Configuration')
            	->findOneBy(array());
            
            if(!$activeCampaign)
            {
            	$fakeRequest = $event->getRequest()->duplicate(null, null, array('_controller' => 'AnunciosAnuncioBundle:Frontend/Portada:comingSoon'));
            	$portadaController = $this->resolver->getController($fakeRequest);
            	$event->setController($portadaController);
            }else 
            {
            	$controller->setActiveCampaign($activeCampaign);
            	$controller->setConfiguration($configuration);
            	$this->container->get('twig')->addGlobal('activeCampaign', $activeCampaign);
            	$this->container->get('twig')->addGlobal('configuration', $configuration);
            }
        }
    }
    
    protected function getDoctrine()
    {
    	return $this->container->get('doctrine');
    }
}