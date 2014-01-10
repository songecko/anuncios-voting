<?php

namespace Anuncios\AnuncioBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 */
class User extends BaseUser
{
    protected $id;
    private $isJurado;
    private $isUsuario;
    private $voting;

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
    /**
     * @var integer
     */
    private $userId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;


    /**
     * Set userId
     *
     * @param integer $userId
     * @return User
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;
    
        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }
}