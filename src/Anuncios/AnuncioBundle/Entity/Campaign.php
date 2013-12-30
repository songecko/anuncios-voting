<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 */
class Campaign
{
    private $id;
    private $name;
    private $isActive;
    private $anuncios;

    public function getId()
    {
        return $this->id;
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

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    
        return $this;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function __construct()
    {
        $this->anuncios = new \Doctrine\Common\Collections\ArrayCollection();
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
}