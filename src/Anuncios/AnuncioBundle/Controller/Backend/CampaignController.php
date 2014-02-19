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
				$this->getXmlDocPremios($form->get('month')->getData(), $form->get('year')->getData(), $form->getData());
			}
			
			if($form->get('month')->getData() == null && $form->get('year')->getData() != null)
			{
				$anunciosFinalistas = $this->getAnunciosFinal($form->get('year')->getData());
				
				foreach($anunciosFinalistas as $anuncioFinalista)
				{
					if($anuncioFinalista != null)
					{
						$anuncio = clone $anuncioFinalista;
						$anuncio->setCampaign($form->getData());
						$manager->persist($anuncio);
					}
				}
				
				$manager->flush();
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
			if($form->get('month')->getData() == null && $form->get('year')->getData() != null)
			{
				$anunciosFinalistas = $this->getAnunciosFinal($form->get('year')->getData());
			
				foreach($anunciosFinalistas as $anuncioFinalista)
				{
					if($anuncioFinalista != null)
					{
						$anuncio = clone $anuncioFinalista;
						$anuncio->setCampaign($form->getData());
						$manager->persist($anuncio);
					}
				}
			
				$manager->flush();
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
	
	public function finalistasAction($id)
	{
		$campaign = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Campaign')
			->find($id);
		
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
		
		$finalistasUsuario = array();
		$finalistasJurado = array();
		
		foreach($categories as $category)
		{
			$finalistasJurado[] = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAnunciosVoteByJurado($campaign, $category);
				
			$finalistasUsuario[] = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAnunciosVoteByUsuario($campaign, $category);
		}
		
		return $this->render('AnunciosAnuncioBundle:Backend/Campaign:finalistas.html.twig', array(
				'campaign'   => $campaign,
				'finalistasUsuario' => $finalistasUsuario,
				'finalistasJurado'  => $finalistasJurado
		));	
	}
	
	public function rankingAction($id, $type)
	{
		$campaign = $this->getDoctrine()
		->getRepository('AnunciosAnuncioBundle:Campaign')
		->find($id);
	
		$categories = $this->getDoctrine()
		->getRepository('AnunciosAnuncioBundle:Category')
		->findAll();
	
		$otherType = $type=='usuarios'?'jurados':'usuarios';
		
		//Ranking
		$ranking = array();
		foreach($categories as $category)
		{
			if($type == 'usuarios')
			{
				$catRanking = array(
					'category' => $category,
					'anuncios' =>  $this->getDoctrine()
						->getRepository('AnunciosAnuncioBundle:Anuncio')
						->getAllAnunciosVoteByUsuario($campaign, $category)
				);
			}else 
			{
				$catRanking = array(
						'category' => $category,
						'anuncios' =>  $this->getDoctrine()
						->getRepository('AnunciosAnuncioBundle:Anuncio')
						->getAllAnunciosVoteByJurado($campaign, $category)
				);
			}
			$ranking[] = $catRanking;
		}
		
		//Hay Empates?
		$categoriesWithoutAnual = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
		$drawCategories = false;
		foreach($categoriesWithoutAnual as $category)
		{
			$anunciosUsuarios = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAllAnunciosVoteByUsuario($campaign, $category);
			$anunciosJurados = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAllAnunciosVoteByJurado($campaign, $category);
			
			$maxVote = 0;
			foreach ($anunciosUsuarios as $anuncio)
			{
				if($anuncio->getVotoUsuario() > $maxVote)
				{
					$maxVote = $anuncio->getVotoUsuario();
				}else if($anuncio->getVotoUsuario() == $maxVote)
				{
					$drawCategories = true;
					break;
				}else if ($anuncio->getVotoUsuario() < $maxVote)
				{
					break;
				}
			}
			
			$maxVote = 0;
			foreach ($anunciosJurados as $anuncio)
			{
				if($anuncio->getVotoJurado() > $maxVote)
				{
					$maxVote = $anuncio->getVotoJurado();
				}else if($anuncio->getVotoJurado() == $maxVote)
				{
					$drawCategories = true;
					break;
				}else if ($anuncio->getVotoJurado() < $maxVote)
				{
					break;
				}
			}
		}
	
		return $this->render('AnunciosAnuncioBundle:Backend/Campaign:ranking.html.twig', array(
				'campaign'   => $campaign,
				'ranking' => $ranking,
				'drawCategories' => $drawCategories,
				'type'  => $type,
				'otherType' => $otherType
		));
	}
	
	public function desdrawingAction($id)
	{
		$campaign = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Campaign')
			->find($id);
		
		$categoriesWithoutAnual = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->getCategoriesWithoutAnual();
		
		foreach($categoriesWithoutAnual as $category)
		{
			$anunciosUsuarios = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAllAnunciosVoteByUsuario($campaign, $category);
			$anunciosJurados = $this->getDoctrine()
				->getRepository('AnunciosAnuncioBundle:Anuncio')
				->getAllAnunciosVoteByJurado($campaign, $category);
				
			
			//Chequear en usuarios
			$maxVote = 0;
			$anunciosDrawedOnCategory = array();
			foreach ($anunciosUsuarios as $anuncio)
			{
				if($anuncio->getVotoUsuario() > $maxVote)
				{
					$maxVote = $anuncio->getVotoUsuario();
					$anunciosDrawedOnCategory[] = $anuncio;
				}else if($anuncio->getVotoUsuario() == $maxVote)
				{
					$anunciosDrawedOnCategory[] = $anuncio;
				}else if ($anuncio->getVotoUsuario() < $maxVote)
				{
					break;
				}
			}
			
			$this->desdrawAnuncios($anunciosDrawedOnCategory, 'usuarios');
				
			//Chequear en jurados
			$maxVote = 0;
			$anunciosDrawedOnCategory = array();
			foreach ($anunciosJurados as $anuncio)
			{
				if($anuncio->getVotoJurado() > $maxVote)
				{
					$maxVote = $anuncio->getVotoJurado();
				}else if($anuncio->getVotoJurado() == $maxVote)
				{
					$anunciosDrawedOnCategory[] = $anuncio;
				}else if ($anuncio->getVotoJurado() < $maxVote)
				{
					break;
				}
			}
			
			$this->desdrawAnuncios($anunciosDrawedOnCategory, 'jurados');
		}
		
		$this->getDoctrine()->getManager()->flush();
		
		return $this->redirectToRoute('anuncios_anuncio_backend_campaign_ranking', array('id' => $id));
	}
	
	public function desdrawAnuncios($anuncios, $type = 'usuarios')
	{
		if(count($anuncios) > 0)
		{
			if($anuncio = $anuncios[array_rand($anuncios)])
			{
				if($type == 'usuarios')
				{
					$anuncio->setVotoUsuario($anuncio->getVotoUsuario() + 1);
				}else {
					$anuncio->setVotoJurado($anuncio->getVotoJurado() + 1);
				}
			}
		}
	}
	
	public function getCleanString($string)
	{
		return utf8_encode($string);
	}
	
	public function getXmlDocPremios($month, $year, $campaign)
	{
		$manager = $this->getDoctrine()->getManager();
		
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
				'Anyo' => $year,
				'Mes' => $month,
				'serviceID' => 'becht34p'
		));
		//ldd($client->response);
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
					$anuncioCampaign = $campaign;
					$anuncioAnuncioId = $xml['Article'][$i]['intArticleID'];
					$anuncioCategory = $this->getCleanString($xml['Article'][$i]['strClassification']);
					$anuncioName = $this->getCleanString($xml['Article'][$i]['strTitle']);
					$anuncioAgency = $this->getCleanString($xml['Article'][$i]['ArticleCard']['Agencia']);
					$anuncioAdvertiser = $this->getCleanString($xml['Article'][$i]['ArticleCard']['Anunciante']);
					$anuncioProduct = $this->getCleanString($xml['Article'][$i]['ArticleCard']['Producto']);
					$anuncioBrand = $this->getCleanString($xml['Article'][$i]['ArticleCard']['Marca']);
					if(is_array($xml['Article'][$i]['ArticleHead']))
					{
						$anuncioSector = $xml['Article'][$i]['ArticleCard']['Sector'];
					}
					$anuncioOtherFields = $xml['Article'][$i]['ArticleCard']['OtherFields'];
					if(is_array($xml['Article'][$i]['ArticleHead']))
					{
						$anuncioImage = $xml['Article'][$i]['ArticleHead']['Resource']['ResourceURL'];
					}
													
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
					$anuncio->setAnuncioId($anuncioAnuncioId);
					
					$j = 1;
					$c = 'campo'.$j;
					$v = 'valor'.$j;
					while(isset($anuncioOtherFields[$c]))
					{
						if(trim($anuncioOtherFields[$c]) != '')
						{
							$anuncio->addOtherFields($this->getCleanString($anuncioOtherFields[$c]), $this->getCleanString($anuncioOtherFields[$v]));
						}
						
						$j++;
						$c = 'campo'.$j;
						$v = 'valor'.$j;
					}
					
					$anuncio->setImage($anuncioImage);
					
					//Resources
					$anuncioResources = $xml['Article'][$i]['ArticleContent']['Resources'];
					if(is_array($anuncioResources))
					{
						foreach($anuncioResources as $anuncioResource)
						{
							$xmlResources = $anuncioResource;
							if(isset($xmlResources['ResourceTypeName']))
							{
								$xmlResources = array($xmlResources);
							}
				
							foreach ($xmlResources as $xmlResource)
							{
								$resource = new Resource();
								$resource->setAnuncio($anuncio);
								$resource->setType($xmlResource['ResourceTypeName']);
								$resource->setLink(html_entity_decode($xmlResource['ResourceURL']));
								$resource->setName($this->getCleanString($xmlResource['ResourceName']));
								$manager->persist($resource);
							}
						}
					}else 
					{
						$anuncioExternalDetail = $xml['Article'][$i]['ArticleCard']['OtherFields']['ExternalDetail'];
						if(!empty($anuncioExternalDetail))
						{
							$resource = new Resource();
							$resource->setAnuncio($anuncio);
							$resource->setType('External');
							$resource->setLink($anuncioExternalDetail);
							$resource->setName($anuncioName);
							$manager->persist($resource);
						}
						else
						{
							//echo "Anuncio '".htmlentities($anuncio->getName())."': \t\tVacio el atributo [ArticleContent] -> [Resource] del xml <br>";
						}
					}
					
					$manager->persist($anuncio);
				}
			}
		}
	}
	
	public function getAnunciosFinal($year)
	{
		$categories = $this->getDoctrine()
			->getRepository('AnunciosAnuncioBundle:Category')
			->findAll();
		
		foreach($categories as $category)
		{
			for($i = 1; $i <= 12; $i++)
			{
				$finalistas[] = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Anuncio')
					->getAnunciosFinalByCategory($category, $i, $year);
			}
		}
		
		return $finalistas;
	}
}