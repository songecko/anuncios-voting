<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * Campaign
 */
class Campaign
{
    private $id;
    private $name;
    private $isActive;
    private $showFinalist;
    private $dateBegin;
    private $dateEnd;
    private $month;
    private $year;
    private $anuncios;
    private $createdAt;
    private $updatedAt;

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
    
    public function setShowFinalist($showFinalist)
    {
    	$this->showFinalist = $showFinalist;
    
    	return $this;
    }
    
    public function getShowFinalist()
    {
    	return $this->showFinalist;
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
 
    public function setMonth($month)
    {
        $this->month = $month;
    
        return $this;
    }

    public function getMonth()
    {
        return $this->month;
    }

    public function getPeriodName()
    {
    	$months = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    	$monthName = $months[$this->getMonth() - 1];
    	
    	return $monthName." del ".$this->getYear();
    }
    
    public function setYear($year)
    {
        $this->year = $year;
    
        return $this;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setDateBegin($dateBegin)
    {
        $this->dateBegin = $dateBegin;
    
        return $this;
    }

    public function getDateBegin()
    {
        return $this->dateBegin;
    }

    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;
    
        return $this;
    }
    
    public function getDateEnd()
    {
        return $this->dateEnd;
    }
}