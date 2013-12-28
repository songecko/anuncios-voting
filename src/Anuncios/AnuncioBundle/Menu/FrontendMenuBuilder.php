<?php
namespace Gecko\NestleBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class FrontendMenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root', array('childrenAttributes' => array('class' => 'nav navbar-nav')));

        $menu->addChild('Inicio', array('route' => 'gecko_nestle_homepage'));
        $menu->addChild('Momentos', array('route' => 'gecko_nestle_moments'));
        $menu->addChild('Marcas', array('route' => 'gecko_nestle_brands'));
        $menu->addChild('Queremos escucharte', array('route' => 'gecko_nestle_contact'));

        $menu->setCurrentUri($request->getRequestUri());
        
        return $menu;
    }
}