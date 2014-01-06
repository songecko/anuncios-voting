<?php

namespace Anuncios\AnuncioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Anuncios\AnuncioBundle\Entity\Campaign;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Resource;
use Anuncios\AnuncioBundle\Entity\Sector;

class LoadAnuncioData implements FixtureInterface
{
	protected $faker;
        
    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }
	
    public function load(ObjectManager $manager)
    {    	
    	$campaign = new Campaign();
    	$campaign->setName('Campaña 1');
    	$campaign->setIsActive(true);
    	
    	$manager->persist($campaign);
    	
    	$categories1 = new Category();
    	$categories2 = new Category();
    	$categories3 = new Category();
    	$categories4 = new Category();
    	$categories5 = new Category();
    	$category[1] = $categories1->setName('Televisión');
    	$category[2] = $categories2->setName('Revistas');
    	$category[3] = $categories3->setName('Radio');
    	$category[4] = $categories4->setName('Exterior');
    	$category[5] = $categories5->setName('Internet');
    	
    	$sector1 = new Sector();
    	$sector2 = new Sector();
    	$sector3 = new Sector();
    	$sector[1] = $sector1->setName('Administraci�n/Organismos p�blicos');
    	$sector[2] = $sector2->setName('Agricultura');
    	$sector[3] = $sector3->setName('Alimentaci�n');
    	
    	$manager->persist($category[1]);
    	$manager->persist($category[2]);
    	$manager->persist($category[3]);
    	$manager->persist($category[4]);
    	$manager->persist($category[5]);
    	
    	$manager->persist($sector[1]);
    	$manager->persist($sector[2]);
    	$manager->persist($sector[3]);
    	
    	for($i=1;$i<=5;$i++)
    	{
	        $anuncio = new Anuncio();
	        $anuncio->setCampaign($campaign);
	    	$anuncio->setCategory($category[$i]);
	    	$anuncio->setName($this->faker->word);
	    	$anuncio->setAgency($this->faker->word);
	    	$anuncio->setAdvertiser($this->faker->word);
	    	$anuncio->setProduct($this->faker->word);
	    	$anuncio->setBrand($this->faker->word);
	    	$anuncio->addOtherFields('prueba1', 'texto1');
	    	$anuncio->setImage('prueba.jpg');
	    	
	    	$resource1 = new Resource();
	    	$resource1->setAnuncio($anuncio);
	    	$resource1->setType('video');
	    	$resource1->setLink('http://vstream.websharecontent.es/vdispatcher.aspx?id=hF2WNob3ogChruEEIN6oTA%3D%3D');
	    	$resource1->setName($this->faker->word);
	    	
	    	$resource2 = new Resource();
	    	$resource2->setAnuncio($anuncio);
	    	$resource2->setType('image');
	    	$resource2->setLink('http://recursos.anuncios.com/files/470/92.jpg');
	    	$resource2->setName($this->faker->word);
	    	
	    	$manager->persist($resource1);
	    	$manager->persist($resource2);
	    	$manager->persist($anuncio);
    	}
        
        $manager->flush();
    }
}