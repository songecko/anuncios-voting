<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use SplFileInfo;
use Anuncios\AnuncioBundle\Model\ImageInterface;

/**
 * Category
 */
class Category implements ImageInterface 
{
    private $id;
    private $name;
    private $slug;
    private $headlineImage;
    private $headlineImageFile;
    private $anuncios;
    private $createdAt;
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }
    
    public function getHeadlineImage()
    {
    	return $this->headlineImage;
    }
    
    public function setHeadlineImage($headlineImage)
    {
    	$this->headlineImage = $headlineImage;
    }
    
    public function getHeadlineImageFile()
    {
    	return $this->headlineImageFile;
    }
    
    public function setHeadlineImageFile($headlineImageFile)
    {
    	$this->headlineImageFile = $headlineImageFile;
    }
    
    public function hasFile()
    {
    	return null !== $this->headlineImageFile;
    }
    
    public function getFile()
    {
    	return $this->headlineImageFile;
    }
    
    public function setFile(SplFileInfo $headlineImageFile)
    {
    	$this->headlineImageFile = $headlineImageFile;
    }
    
    public function hasPath()
    {
    	return null !== $this->headlineImage;
    }
    
    public function getPath()
    {
    	return $this->headlineImage;
    }
    
    public function setPath($headlineImage)
    {
    	$this->headlineImage = $headlineImage;
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
    
    public function getSlug()
    {
    	return $this->slug;
    }
    
    public function setSlug($slug)
    {
    	$this->slug = $slug;
    }
}