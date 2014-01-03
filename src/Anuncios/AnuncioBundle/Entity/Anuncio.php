<?php

namespace Anuncios\AnuncioBundle\Entity;

use SplFileInfo;
use Doctrine\ORM\Mapping as ORM;
use Anuncios\AnuncioBundle\Model\ImageInterface;

/**
 * Anuncio
 */
class Anuncio implements ImageInterface
{
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
    private $resources;
    private $votoJurado;
    private $votoUsuario;

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
    
    public function setFile(SplFileInfo $file)
    {
    	$this->file = $file;
    }
    
    public function hasPath()
    {
    	return null !== $this->image;
    }
    
    public function getPath()
    {
    	return $this->image;
    }
    
    public function setPath($image)
    {
    	$this->image = $image;
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
}