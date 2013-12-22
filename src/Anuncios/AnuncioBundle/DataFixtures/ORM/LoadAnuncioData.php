<?php

namespace Anuncios\AnuncioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Resource;

class LoadUserData implements FixtureInterface
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
    	$categories1 = new Category();
    	$categories2 = new Category();
    	$categories3 = new Category();
    	$categories4 = new Category();
    	$categories5 = new Category();
    	$category[1] = $categories1->setName('Television');
    	$category[2] = $categories2->setName('Revistas');
    	$category[3] = $categories3->setName('Radio');
    	$category[4] = $categories4->setName('Exterior');
    	$category[5] = $categories5->setName('Internet');
    	
    	$manager->persist($category[1]);
    	$manager->persist($category[2]);
    	$manager->persist($category[3]);
    	$manager->persist($category[4]);
    	$manager->persist($category[5]);
    	
    	for($i=1;$i<=5;$i++)
    	{
	        $anuncio = new Anuncio();
	    	$anuncio->setCategory($category[$i]);
	    	$anuncio->setName($this->faker->word);
	    	$anuncio->setAgency($this->faker->word);
	    	$anuncio->setAdvertiser($this->faker->word);
	    	$anuncio->setProduct($this->faker->word);
	    	$anuncio->setBrand($this->faker->word);
	    	$anuncio->setOtherFields($this->faker->text);
	    	$anuncio->setImage('prueba.jpg');
	    	
	    	$resource = new Resource();
	    	$resource->setAnuncio($anuncio);
	    	$resource->setType('video');
	    	$resource->setLink('http://vstream.websharecontent.es/vdispatcher.aspx?id=hF2WNob3ogChruEEIN6oTA%3D%3D');
	    	$resource->setName($this->faker->word);
	    	
	    	$manager->persist($resource);
	    	$manager->persist($anuncio);
    	}
        
        $manager->flush();
    }
}