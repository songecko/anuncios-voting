<?php

namespace Anuncios\AnuncioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
    	$category = new Category();
    	$category->setName('Television');
    	
        $anuncio = new Anuncio();
    	$anuncio->setCategory($category);
    	$anuncio->setName('Tulipan');
    	$anuncio->setAgency('Compact FMRG');
    	$anuncio->setAdvertiser('Unilever');
    	$anuncio->setProduct('Margarina');
    	$anuncio->setBrand('Tulipan');
    	$anuncio->setSector('Alimentacion');
    	$anuncio->setClientContact('Baptiste Azais');
    	$anuncio->setCreativeTeam('Virgilio Ferrer y Sergi Milà');
    	$anuncio->setBusinessDirection('Roxana Gavosto');
    	$anuncio->setMediaAgency('Mindshare');
    	$anuncio->setProducer('RCR');
    	$anuncio->setDirector('Sergi Capellas');
    	$anuncio->setSoundStudio('Idea Sonora');
    	$anuncio->setPiece('Spot TV 30');
    	$anuncio->setTitle('Pasa la receta');
    	$anuncio->setImage('prueba.jpg');

        $manager->persist($category);
        $manager->persist($anuncio);
        $manager->flush();
    }
}