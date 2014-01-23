<?php

namespace Anuncios\AnuncioBundle\Controller\Backend;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Anuncios\AnuncioBundle\Entity\Category;
use Anuncios\AnuncioBundle\Entity\Anuncio;
use Anuncios\AnuncioBundle\Entity\Resource;

class CampaignController extends ResourceController
{
	public function create($resource)
	{
		parent::create($resource);
		
		$form = $this->getForm($resource);
		
		$request = $this->getRequest();
		
		$manager = $this->getDoctrine()->getManager();
		
		if ($request->isMethod('POST') && $form->bind($request)->isValid())
		{
			if($form->get('month')->getData() != null && $form->get('year')->getData() != null)
			{
				date_default_timezone_set('America/Los_Angeles');
				
				$error = false;
				$message = "Se produjo un error";
				
				$client = new \nusoap_client('http://wspremios.anuncios.com/SingleSingOn.asmx?WSDL', true);
					
				//En el proyecto indicar al usuario que hubo un problema
				$err = $client->getError();
				if ($err)
				{
					$error = true;
				}
				
				//Configuracion SOAP
				$client->setUseCurl(true);
				$client->setCredentials("wspremios", "v01KxO17my5WgaCiYxpD", 'ntlm');
				//$client->useHTTPPersistentConnection();
				//$client->setCurlOption(CURLOPT_USERPWD, 'wspremios:v01KxO17my5WgaCiYxpD');
				$client->loadWSDL();
				$result = $client->call('GetXMLDocPremios', array(
						'Anyo' => $form->get('year')->getData(),
						'Mes' => $form->get('month')->getData(),
						'serviceID' => 'becht34p'
				));
				
				//En el proyecto indicar al usuario que hubo un problema
				if ($client->fault) 
				{
					$error = true;
				} 
				else 
				{
					// Check for errors
					$err = $client->getError();
					if ($err) 
					{
						$error = true;
					} 
					else 
					{
						//En el proyecto, parsear la respuesta
						$xml = $result['GetXMLDocPremiosResult']['ArticleSet'];
						$quantity = count($xml['Article']);
						for($i = 0; $i < $quantity; $i++) 
						{
							$anuncioCampaign = $form->getData();
							$anuncioCategory = $this->getWithEntities($xml['Article'][$i]['strClassification']);
							$anuncioName = $this->getWithEntities($xml['Article'][$i]['strTitle']);
							$anuncioAgency = $this->getWithEntities($xml['Article'][$i]['ArticleCard']['Agencia']);
							$anuncioAdvertiser = $this->getWithEntities($xml['Article'][$i]['ArticleCard']['Anunciante']);
							$anuncioProduct = $this->getWithEntities($xml['Article'][$i]['ArticleCard']['Producto']);
							$anuncioBrand = $this->getWithEntities($xml['Article'][$i]['ArticleCard']['Marca']);
							$anuncioSector = $xml['Article'][$i]['ArticleCard']['Sector'];
							$anuncioOtherFields = $xml['Article'][$i]['ArticleCard']['OtherFields'];
							$anuncioImage = $xml['Article'][$i]['ArticleHead']['Resource']['ResourceURL'];
							
							$category = $this->getDoctrine()
		    					->getRepository('AnunciosAnuncioBundle:Category')
		    					->findOneByName($anuncioCategory);
							
							$sector = $this->getDoctrine()
								->getRepository('AnunciosAnuncioBundle:Sector')
								->findOneBySectorId($anuncioSector);
							
							if(!$category)
							{
								$category = new Category();
								$category->setName($anuncioCategory);
								
								$manager->persist($category);
								$manager->flush();
							}
							
							$anuncio = new Anuncio();
							$anuncio->setCampaign($anuncioCampaign);
							$anuncio->setCategory($category);
							$anuncio->setSector($sector);
							$anuncio->setName($anuncioName);
							$anuncio->setAgency($anuncioAgency);
							$anuncio->setAdvertiser($anuncioAdvertiser);
							$anuncio->setProduct($anuncioProduct);
							$anuncio->setBrand($anuncioBrand);
							
							$j = 1;
							$c = 'campo'.$j;
							$v = 'valor'.$j;
							while(isset($anuncioOtherFields[$c]))
							{
								$anuncio->addOtherFields($this->getWithEntities($anuncioOtherFields[$c]), $this->getWithEntities($anuncioOtherFields[$v]));
								$j++;
								$c = 'campo'.$j;
								$v = 'valor'.$j;
							}
							
							$anuncio->setImage($anuncioImage);
							
							//$resources = new Resource();
							
							$manager->persist($anuncio);
						}
					}
				}
			}
		}
		$event = $this->dispatchEvent('pre_create', $resource);

        if (!$event->isStopped()) {
            $manager->persist($resource);
            $this->dispatchEvent('create', $resource);
            $manager->flush();
            $this->dispatchEvent('post_create', $resource);
        }

        return $event;
	}
	
	public function update($resource)
	{
		parent::update($resource);
	
		$form = $this->getForm($resource);
	
		$request = $this->getRequest();
	
		$manager = $this->getDoctrine()->getManager();
	
		if (($request->isMethod('PUT') || $request->isMethod('POST')) && $form->bind($request)->isValid())
		{
			if($form->get('month')->getData() != null && $form->get('year')->getData() != null)
			{
				date_default_timezone_set('America/Los_Angeles');
				
				$error = false;
				$message = "Se produjo un error";
				
				$client = new \nusoap_client('http://wspremios.anuncios.com/SingleSingOn.asmx?WSDL', true);
					
				//En el proyecto indicar al usuario que hubo un problema
				$err = $client->getError();
				if ($err)
				{
					$error = true;
				}
				
				//Configuracion SOAP
				$client->setUseCurl(true);
				$client->setCredentials("wspremios", "v01KxO17my5WgaCiYxpD", 'ntlm');
				//$client->useHTTPPersistentConnection();
				//$client->setCurlOption(CURLOPT_USERPWD, 'wspremios:v01KxO17my5WgaCiYxpD');
				$client->loadWSDL();
				$result = $client->call('GetXMLDocPremios', array(
						'Anyo' => $form->get('year')->getData(),
						'Mes' => $form->get('month')->getData(),
						'serviceID' => 'becht34p'
				));
				
				//En el proyecto indicar al usuario que hubo un problema
				if ($client->fault) 
				{
					$error = true;
				} 
				else 
				{
					// Check for errors
					$err = $client->getError();
					if ($err) 
					{
						$error = true;
					} 
					else 
					{
						//En el proyecto, parsear la respuesta
						$xml = $result['GetXMLDocPremiosResult']['ArticleSet'];
						$quantity = count($xml['Article']);
						for($i = 0; $i < $quantity; $i++) 
						{
							$anuncioCampaign = $form->getData();
							$anuncioCategory = $xml['Article'][$i]['strClassification'];
							$anuncioName = $xml['Article'][$i]['strTitle'];
							$anuncioAgency = $xml['Article'][$i]['ArticleCard']['Agencia'];
							$anuncioAdvertiser = $xml['Article'][$i]['ArticleCard']['Anunciante'];
							$anuncioProduct = $xml['Article'][$i]['ArticleCard']['Producto'];
							$anuncioBrand = $xml['Article'][$i]['ArticleCard']['Marca'];
							$anuncioSector = $xml['Article'][$i]['ArticleCard']['Sector'];
							$anuncioOtherFields = $xml['Article'][$i]['ArticleCard']['OtherFields'];
							$anuncioImage = $xml['Article'][$i]['ArticleHead']['Resource']['ResourceURL'];
							
							$category = $this->getDoctrine()
		    					->getRepository('AnunciosAnuncioBundle:Category')
		    					->findOneByName($anuncioCategory);
							
							$sector = $this->getDoctrine()
								->getRepository('AnunciosAnuncioBundle:Sector')
								->find($anuncioSector);
							
							if(!$category)
							{
								$category = new Category();
								$category->setName($anuncioCategory);
								
								$manager->persist($category);
								$manager->flush();
							}
							
							$anuncio = new Anuncio();
							$anuncio->setCampaign($anuncioCampaign);
							$anuncio->setCategory($category);
							$anuncio->setSector($sector);
							$anuncio->setName($anuncioName);
							$anuncio->setAgency($anuncioAgency);
							$anuncio->setAdvertiser($anuncioAdvertiser);
							$anuncio->setProduct($anuncioProduct);
							$anuncio->setBrand($anuncioBrand);
							
							$j = 1;
							$c = 'campo'.$j;
							$v = 'valor'.$j;
							while(isset($anuncioOtherFields[$c]))
							{
								$anuncio->addOtherFields(htmlentities($anuncioOtherFields[$c], ENT_SUBSTITUTE, 'ISO-8859-15'), htmlentities($anuncioOtherFields[$v], ENT_SUBSTITUTE, 'ISO-8859-15'));
								$j++;
								$c = 'campo'.$j;
								$v = 'valor'.$j;
							}
							
							$anuncio->setImage($anuncioImage);
							
							/*$anuncioResources = $xml['Article']['0']['ArticleContent']['Resources'];
							$quantityResources = count($anuncioResources['Resource']);
							echo $quantityResources;
							die;
							foreach($anuncioResources as $anuncioResource)
							{
								print_r($anuncioResource);
								die;
								$resources = new Resource();
								$resources->setAnuncio($anuncio);
								$resources->setType($anuncioResource['ResourceTypeName']);
								$resources->setLink($anuncioResource['ResourceURL']);
								$resources->setName($anuncioResource['ResourceName']);
								
								$manager->persist($resources);
							}*/
							
							$manager->persist($anuncio);
						}
					}
				}
			}
		}
		$event = $this->dispatchEvent('pre_create', $resource);
	
		if (!$event->isStopped()) 
		{
			$manager->persist($resource);
			$this->dispatchEvent('create', $resource);
			$manager->flush();
			$this->dispatchEvent('post_create', $resource);
		}
	
		return $event;
	}
	
	public function getWithEntities($string)
	{
		//return htmlentities($string, ENT_SUBSTITUTE, 'ISO-8859-15');
		return utf8_encode($string);
	}
}