<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Anuncio
 */
class Anuncio
{
	const FINALIST_TYPE_JURADO = 'jurado';
	const FINALIST_TYPE_USUARIO = 'usuario';
	
    private $id;
    private $name;
    private $agency;
    private $advertiser;
    private $product;
    private $brand;
    private $otherFields;
    private $image;
    private $file;
    private $category;
    private $campaign;
    private $finalistType;
    private $sector;
    private $resources;
    private $voting;
    private $votoJurado;
    private $votoUsuario;
    private $createdAt;
    private $updatedAt;
    private $anuncioId;

    public function __clone()
    {
    	if ($this->id) 
    	{
    		$this->id = null;
    		$this->createdAt = new DateTime('now');
    		$clonedResources = new \Doctrine\Common\Collections\ArrayCollection();
    		foreach ($this->resources as $resource)
    		{
	    		$clonedResources[] = clone $resource;
	    		$resource->setAnuncio($this);
    		}
    		$this->resources = $clonedResources;
    	}
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function hasFile()
    {
    	return null !== $this->file;
    }
    
    public function getFile()
    {
    	return $this->file;
    }
    
    public function setFile(File $file)
    {
    	$this->file = $file;
    	
    	if ($this->image) {
    		$this->setUpdatedAt(new \DateTime('now'));
    	}
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    public function getAgency()
    {
        return $this->agency;
    }

    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;

        return $this;
    }

    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBrand()
    {
        return $this->brand;
    }

    public function setOtherFields($otherFields)
    {
        $this->otherFields = array();

        foreach ($otherFields as $otherField)
        {
            $this->addOtherFields($otherField);
        }

        return $this;
    }

    public function getOtherFields()
    {
        return $this->otherFields;
    }
    
    public function addOtherFields($campo, $valor)
    {
    	/*if (!in_array($otherFields, $this->otherFields, true))
    	{
    		$this->otherFields[] = $otherFields;
    	}*/
    	$this->otherFields[$campo] = $valor;
    
    	return $this;
    }
    
    public function removeOtherFields($otherFields)
    {
    	if (false !== $key = array_search(strtoupper($otherFields), $this->otherFields, true)) {
    		unset($this->otherFields[$key]);
    		$this->otherFields = array_values($this->otherFields);
    	}
    
    	return $this;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setCategory(\Anuncios\AnuncioBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function __construct()
    {
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->otherFields = array();
        $this->votoJurado = 0;
        $this->votoUsuario = 0;
        $this->createdAt = new DateTime('now');
    }

    public function addResource(\Anuncios\AnuncioBundle\Entity\Resource $resources)
    {
        $this->resources[] = $resources;

        return $this;
    }

    public function removeResource(\Anuncios\AnuncioBundle\Entity\Resource $resources)
    {
        $this->resources->removeElement($resources);
    }

    public function getResources()
    {
        return $this->resources;
    }

    public function setCampaign(\Anuncios\AnuncioBundle\Entity\Campaign $campaign = null)
    {
        $this->campaign = $campaign;
    
        return $this;
    }

    public function getCampaign()
    {
        return $this->campaign;
    }

    public function setFinalistType($finalistType)
    {
    	if (!in_array($finalistType, array(self::FINALIST_TYPE_JURADO, self::FINALIST_TYPE_USUARIO))) {
    		throw new \InvalidArgumentException("Invalid finalist type");
    	}
    	
    	$this->finalistType = $finalistType;
    
    	return $this;
    }
    
    public function getFinalistType()
    {
    	return $this->finalistType;
    }
    
    public function setSector(\Anuncios\AnuncioBundle\Entity\Sector $sector = null)
    {
    	$this->sector = $sector;
    
    	return $this;
    }
    
    public function getSector()
    {
    	return $this->sector;
    }
    
    public function setVotoJurado($votoJurado)
    {
        $this->votoJurado = $votoJurado;
    
        return $this;
    }

    public function getVotoJurado()
    {
        return $this->votoJurado;
    }

    public function setVotoUsuario($votoUsuario)
    {
        $this->votoUsuario = $votoUsuario;
    
        return $this;
    }

    public function getVotoUsuario()
    {
        return $this->votoUsuario;
    }

    public function addVoting(\Anuncios\AnuncioBundle\Entity\Voting $voting)
    {
        $this->voting[] = $voting;
    
        return $this;
    }

    public function removeVoting(\Anuncios\AnuncioBundle\Entity\Voting $voting)
    {
        $this->voting->removeElement($voting);
    }

    public function getVoting()
    {
        return $this->voting;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
    
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    public function setAnuncioId($anuncioId)
    {
    	$this->anuncioId = $anuncioId;
    
    	return $this;
    }
    
    public function getAnuncioId()
    {
    	return $this->anuncioId;
    }
}