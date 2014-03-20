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
    private $logoHome;
    private $logoHomeFile;
    private $favicon;
    private $faviconFile;
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

    /** TITLE HOME IMAGE **/
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
    
    
    /** LOGO HOME **/
    public function setLogoHome($logo)
    {
    	$this->logoHome = $logo;
    
    	return $this;
    }
    
    public function getLogoHome()
    {
    	return $this->logoHome;
    }
    
    public function hasLogoHomeFile()
    {
    	return null !== $this->logoHomeFile;
    }
    
    public function getLogoHomeFile()
    {
    	return $this->logoHomeFile;
    }
    
    public function setLogoHomeFile(File $file)
    {
    	$this->logoHomeFile = $file;
    
    	if ($this->logoHome) {
    		$this->setUpdatedAt(new \DateTime('now'));
    	}
    }
    
    
    /** FAVICON **/
    public function setFavicon($favicon)
    {
    	$this->favicon = $favicon;
    
    	return $this;
    }
    
    public function getFavicon()
    {
    	return $this->favicon;
    }
    
    public function hasFaviconFile()
    {
    	return null !== $this->faviconFile;
    }
    
    public function getFaviconFile()
    {
    	return $this->faviconFile;
    }
    
    public function setFaviconFile(File $file)
    {
    	$this->faviconFile = $file;
    
    	if ($this->favicon) {
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