<?php
namespace Anuncios\AnuncioBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class BackendMenuBuilder
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
        $menu = $this->factory->createItem('root', array(
            'childrenAttributes' => array(
                'class' => 'nav'
            )
        ));

        $childOptions = array(
            'childrenAttributes' => array('class' => 'nav'),
            'labelAttributes'    => array('class' => 'nav-header')
        );

        $menu->addChild('campaign', array(
        		'route' => 'anuncios_anuncio_backend_campaign_index',
        		'labelAttributes' => array('icon' => 'icon-barcode'),
        ))->setLabel("Campañas");
        
        $menu->addChild('anuncio', array(
            'route' => 'anuncios_anuncio_backend_anuncio_index',
            'labelAttributes' => array('icon' => 'icon-barcode'),
        ))->setLabel("Anuncios");
        
        
        return $menu;
    }
}