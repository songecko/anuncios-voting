<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Resource
 */
class Resource
{
    private $id;
    private $type;
    private $link;
    private $name;
    private $anuncio;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
    	$this->createdAt = new DateTime('now');
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    public function getLink()
    {
        return $this->link;
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

    public function setAnuncio(\Anuncios\AnuncioBundle\Entity\Anuncio $anuncio = null)
    {
        $this->anuncio = $anuncio;

        return $this;
    }

    public function getAnuncio()
    {
        return $this->anuncio;
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