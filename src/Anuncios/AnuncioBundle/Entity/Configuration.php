<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Configuration
 */
class Configuration
{
    private $id;
    private $titleHomeImage;
    private $titleHomeImageFile;
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

    public function setTitleHomeImage($image)
    {
    	$this->titleHomeImage = $image;
    
    	return $this;
    }
    
    public function getTitleHomeImage()
    {
    	return $this->titleHomeImage;
    }
    
    public function hasTitleHomeImageFile()
    {
    	return null !== $this->titleHomeImageFile;
    }
    
    public function getTitleHomeImageFile()
    {
    	return $this->titleHomeImageFile;
    }
    
    public function setTitleHomeImageFile(File $file)
    {
    	$this->titleHomeImageFile = $file;
    	
    	if ($this->titleHomeImage) {
    		$this->setUpdatedAt(new \DateTime('now'));
    	}
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