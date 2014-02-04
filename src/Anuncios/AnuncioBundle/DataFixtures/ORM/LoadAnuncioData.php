<?php

namespace Anuncios\AnuncioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Faker\Factory as FakerFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Finder\Finder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Anuncios\AnuncioBundle\Entity\User;
use Anuncios\AnuncioBundle\Entity\Campaign;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Resource;
use Anuncios\AnuncioBundle\Entity\Sector;

class LoadAnuncioData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
	protected $faker;
    protected $container;    
    /**
    * Constructor.
    */
    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }
    
    public function setContainer(ContainerInterface $container = null)
    {
    	$this->container = $container;
    }
    
    protected function get($id)
    {
    	return $this->container->get($id);
    }
    
    public function getOrder()
    {
    	return 4;
    }    
    
    public function load(ObjectManager $manager)
    {
    	$userAdmin = new User();
    	$userAdmin->setUserId(1);
    	$userAdmin->setUsername('admin');
    	$userAdmin->setEmail('admin@anuncio.com');
    	$userAdmin->setPlainPassword('123456');
    	$userAdmin->setEnabled(true);
    	$userAdmin->setRoles(array('ROLE_ADMIN'));
    	$userAdmin->setIsJurado(false);
    	
    	$manager->persist($userAdmin);
    	
    	$userJurado = new User();
    	$userJurado->setUserId(2);
    	$userJurado->setUsername('jurado@anuncio.com');
    	$userJurado->setEmail('jurado@anuncio.com');
    	$userJurado->setPlainPassword('123456');
    	$userJurado->setEnabled(true);
    	$userJurado->setRoles(array('ROLE_USER'));
    	$userJurado->setIsJurado(true);
    	 
    	$manager->persist($userJurado);
    	
    	$userUsuario = new User();
    	$userUsuario->setUserId(3);
    	$userUsuario->setUsername('usuario@anuncio.com');
    	$userUsuario->setEmail('usuario@anuncio.com');
    	$userUsuario->setPlainPassword('123456');
    	$userUsuario->setEnabled(true);
    	$userUsuario->setRoles(array('ROLE_USER'));
    	$userUsuario->setIsJurado(false);
    	
    	$manager->persist($userUsuario);
    	
    	$userJurado2 = new User();
    	$userJurado2->setUserId(4);
    	$userJurado2->setUsername('pruebas3@pruebas.es');
    	$userJurado2->setEmail('pruebas3@pruebas.es');
    	$userJurado2->setPlainPassword('123456');
    	$userJurado2->setEnabled(true);
    	$userJurado2->setRoles(array('ROLE_USER'));
    	$userJurado2->setIsJurado(true);
    	
    	$manager->persist($userJurado2);
    	
    	$campaign = new Campaign();
    	$campaign->setName('Campaña 1');
    	$campaign->setIsActive(true);
    	$campaign->setDateBegin(new \DateTime("now"));
    	$campaign->setDateEnd(new \DateTime("+7 day"));
    	$campaign->setMonth(date('n'));
    	$campaign->setYear(date('Y'));
    	
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
    	
    	$manager->persist($category[1]);
    	$manager->persist($category[2]);
    	$manager->persist($category[3]);
    	$manager->persist($category[4]);
    	$manager->persist($category[5]);
    	
    	$sector1 = new Sector();
    	$sector2 = new Sector();
    	$sector3 = new Sector();
    	$sector4 = new Sector();
    	$sector5 = new Sector();
    	$sector[1] = $sector1->setName('Administración/Organismos públicos');
    	$sector[2] = $sector2->setName('Agricultura');
    	$sector[3] = $sector3->setName('Alimentación');
    	$sector[4] = $sector4->setName('Automoción');
    	$sector[5] = $sector5->setName('Bebidas');
    	
    	$manager->persist($sector[1]);
    	$manager->persist($sector[2]);
    	$manager->persist($sector[3]);
    	$manager->persist($sector[4]);
    	$manager->persist($sector[5]);
    	
    	for($i=1;$i<=5;$i++)
    	{
	        $anuncio = new Anuncio();
	        $anuncio->setCampaign($campaign);
	    	$anuncio->setCategory($category[$i]);
	    	$anuncio->setSector($sector[$i]);
	    	$anuncio->setName($this->faker->word);
	    	$anuncio->setAgency($this->faker->word);
	    	$anuncio->setAdvertiser($this->faker->word);
	    	$anuncio->setProduct($this->faker->word);
	    	$anuncio->setBrand($this->faker->word);
	    	$anuncio->addOtherFields('prueba1', 'texto1');
	    	$anuncio->setImage('http://recursos.anuncios.com/files/470/92.jpg');
	    	
	    	$resource1 = new Resource();
	    	$resource1->setAnuncio($anuncio);
	    	$resource1->setType('Video MP4');
	    	$resource1->setLink('http://vstream.websharecontent.es/vdispatcher.aspx?id=hF2WNob3ogChruEEIN6oTA%3D%3D');
	    	$resource1->setName($this->faker->word);
	    	
	    	$resource2 = new Resource();
	    	$resource2->setAnuncio($anuncio);
	    	$resource2->setType('Imagen');
	    	$resource2->setLink('http://recursos.anuncios.com/files/470/92.jpg');
	    	$resource2->setName($this->faker->word);
	    	
	    	$manager->persist($resource1);
	    	$manager->persist($resource2);
	    	$manager->persist($anuncio);
    	}
        
        $manager->flush();
    }
}
