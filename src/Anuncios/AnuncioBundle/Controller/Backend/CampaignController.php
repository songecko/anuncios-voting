<?php

namespace Anuncios\AnuncioBundle\Controller\Backend;

use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
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
			if($form->get('file')->getData() != null)
			{
				$xmlPath = $form->get('file')->getData()->getPathname();
				$xml = simplexml_load_file($xmlPath);
				$quantity = count($xml->Article);
				for($i = 0; $i < $quantity; $i++) 
				{
					$anuncioCampaign = $form->getData();
					$anuncioCategory = $xml->Article[$i]->strClassification;
					$anuncioName = $xml->Article[$i]->strTitle;
					$anuncioAgency = $xml->Article[$i]->ArticleCard->Agencia;
					$anuncioAdvertiser = $xml->Article[$i]->ArticleCard->Anunciante;
					$anuncioProduct = $xml->Article[$i]->ArticleCard->Producto;
					$anuncioBrand = $xml->Article[$i]->ArticleCard->Marca;
					$anuncioSector = $xml->Article[$i]->ArticleCard->Sector;
					$anuncioOtherFields = $xml->Article[$i]->ArticleCard->OtherFields;
					$anuncioImage = $xml->Article[$i]->ArticleHead->Resource->ResourceURL;
					
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
					while(isset($anuncioOtherFields->$c))
					{
						$anuncio->addOtherFields((string)$anuncioOtherFields->$c, (string)$anuncioOtherFields->$v);
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
			if($form->get('file')->getData() != null)
			{
				$xmlPath = $form->get('file')->getData()->getPathname();
				$xml = simplexml_load_file($xmlPath);
				$quantity = count($xml->Article);
	
				for($i = 0; $i < $quantity; $i++)
				{
					$anuncioCampaign = $form->getData();
					$anuncioCategory = $xml->Article[$i]->strClassification;
					$anuncioName = $xml->Article[$i]->strTitle;
					$anuncioAgency = $xml->Article[$i]->ArticleCard->Agencia;
					$anuncioAdvertiser = $xml->Article[$i]->ArticleCard->Anunciante;
					$anuncioProduct = $xml->Article[$i]->ArticleCard->Producto;
					$anuncioBrand = $xml->Article[$i]->ArticleCard->Marca;
					$anuncioSector = $xml->Article[$i]->ArticleCard->Sector;
					$anuncioOtherFields = $xml->Article[$i]->ArticleCard->OtherFields;
					$anuncioImage = $xml->Article[$i]->ArticleHead->Resource->ResourceURL;
						
					$category = $this->getDoctrine()
					->getRepository('AnunciosAnuncioBundle:Category')
	    					->findOneByName($anuncioCategory);
		
		    		$anuncio = new Anuncio();
		    		$anuncio->setCampaign($anuncioCampaign);
					$anuncio->setCategory($category);
					$anuncio->setName($anuncioName);
					$anuncio->setAgency($anuncioAgency);
					$anuncio->setAdvertiser($anuncioAdvertiser);
					$anuncio->setProduct($anuncioProduct);
					$anuncio->setBrand($anuncioBrand);
						
					$j = 1;
					$c = 'campo'.$j;
					$v = 'valor'.$j;
					while(isset($anuncioOtherFields->$c))
					{
						$anuncio->addOtherFields((string)$anuncioOtherFields->$c, (string)$anuncioOtherFields->$v);
						$j++;
						$c = 'campo'.$j;
						$v = 'valor'.$j;
					}
						
					$anuncio->setImage($anuncioImage);
						
					$manager->persist($anuncio);
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
}