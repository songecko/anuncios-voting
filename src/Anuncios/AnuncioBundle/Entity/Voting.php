<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voting
 */
class Voting
{
    private $id;
    private $user;
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

    public function setUser(\Anuncios\AnuncioBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    public function getUser()
    {
        return $this->user;
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