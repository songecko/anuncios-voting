<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Sector
 */
class Sector
{
    private $id;
    private $name;
    private $sectorId;
	private $anuncios;
	private $createdAt;
	private $updatedAt;

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
    	$this->id = $id;
    
    	return $this;
    }
    
    public function setSectorId($sectorId)
    {
    	$this->sectorId = $sectorId;
    
    	return $this;
    }
    
    public function getSectorId()
    {
    	return $this->sectorId;
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
    
    public function __construct()
    {
    	$this->anuncios = new \Doctrine\Common\Collections\ArrayCollection();
    	$this->createdAt = new DateTime('now');
    }
    
    public function addAnuncio(\Anuncios\AnuncioBundle\Entity\Anuncio $anuncios)
    {
    	$this->anuncios[] = $anuncios;
    
    	return $this;
    }
    
    public function removeAnuncio(\Anuncios\AnuncioBundle\Entity\Anuncio $anuncios)
    {
    	$this->anuncios->removeElement($anuncios);
    }
    
    public function getAnuncios()
    {
    	return $this->anuncios;
    }
    
    public function __toString()
    {
    	return $this->getName();
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
}