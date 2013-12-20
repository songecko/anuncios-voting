<?php

namespace Anuncios\AnuncioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;

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
    	$category1 = new Category();
    	$category1->setName('Television');
    	$category2 = new Category();
    	$category2->setName('Revistas');
    	$category3 = new Category();
    	$category3->setName('Radio');
    	$category4 = new Category();
    	$category4->setName('Exterior');
    	$category5 = new Category();
    	$category5->setName('Internet');
    	for($i=1;$i<=5;$i++)
    	{
	        $anuncio = new Anuncio();
	    	$anuncio->setCategory($category1);
	    	$anuncio->setName($this->faker->word);
	    	$anuncio->setAgency($this->faker->word);
	    	$anuncio->setAdvertiser($this->faker->word);
	    	$anuncio->setProduct($this->faker->word);
	    	$anuncio->setBrand($this->faker->word);
	    	$anuncio->setOtherFields($this->faker->text);
	    	$anuncio->setImage('prueba.jpg');
	    	
	    	$manager->persist($anuncio);
    	}

        $manager->persist($category1);
        $manager->persist($category2);
        $manager->persist($category3);
        $manager->persist($category4);
        $manager->persist($category5);
        
        $manager->flush();
    }
}