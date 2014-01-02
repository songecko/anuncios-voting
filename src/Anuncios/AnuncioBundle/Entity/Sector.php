<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sector
 */
class Sector
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;
	private $anuncios;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Sector
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
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
