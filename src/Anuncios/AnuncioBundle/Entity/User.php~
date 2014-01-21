<?php

namespace Anuncios\AnuncioBundle\Entity;

use DateTime;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser
{
    protected $id;
    private $userId;
    private $name;
    private $surname;
    private $isJurado;
    private $voting;
    private $createdAt;
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setIsJurado($isJurado)
    {
        $this->isJurado = $isJurado;
    
        return $this;
    }

    public function getIsJurado()
    {
        return $this->isJurado;
    }

    public function __construct()
    {
        $this->voting = new \Doctrine\Common\Collections\ArrayCollection();
        
        $this->createdAt = new DateTime('now');
        $this->isJurado = false;
        
        parent::__construct();
    }
    
    public function addVoting(\Anuncios\AnuncioBundle\Entity\Voting $voting)
    {
        $this->voting[] = $voting;
    
        return $this;
    }

    public function removeVoting(\Anuncios\AnuncioBundle\Entity\Voting $voting)
    {
        $this->voting->removeElement($voting);
    }

    public function getVoting()
    {
        return $this->voting;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }
    
    public function getUserId()
    {
        return $this->userId;
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
    
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    public function getSurname()
    {
        return $this->surname;
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