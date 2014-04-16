<?php

namespace Anuncios\AnuncioBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Anuncios\AnuncioBundle\Controller\Frontend\BaseFrontendController;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\HttpKernel;

class FrontendListener
{
	protected $container;
	protected $resolver;
	protected $activeCampaign;
	
    public function __construct(Container $container, ControllerResolverInterface $resolver)
    {
    	$this->container = $container;
    	$this->resolver = $resolver;
    }
    
    public function onKernelRequest(GetResponseEvent $event)
    {
    	if ($event->getRequestType() !== HttpKernel::MASTER_REQUEST) {
    		return;
    	}
    	
    	$security = $this->container->get('security.context');
    	if($security->getToken() && $this->container->get('security.context')->isGranted('ROLE_USER'))
    	{
    		return;
    	}
    	
    	$request = $event->getRequest();
    	$router = $this->container->get('router');
    	$routeParams = $router->match($request->getPathInfo());
    	
    	$routeName = $routeParams['_route'];
    	if ($routeName[0] == '_') {
    		return;
    	}
    	
    	if(!in_array($routeName, array('anuncios_anuncio_login', 'fos_user_security_login', 'fos_user_security_check')))
    	{
	    	$activeCampaign = $this->getActiveCampaign();
	    	
	    	if($activeCampaign && $activeCampaign->isAnual())
	    	{
		    	$event->setResponse(new RedirectResponse($router->generate('anuncios_anuncio_login')));
	    	}
    	}
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
            $activeCampaign = $this->getActiveCampaign();
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
    
    protected function getActiveCampaign()
    {
    	if(!$this->activeCampaign) 
    	{
    		$this->activeCampaign = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Campaign')
				->getCampaignActive();
    	}
    	
    	return $this->activeCampaign;
    }
    
    protected function getDoctrine()
    {
    	return $this->container->get('doctrine');
    }
}