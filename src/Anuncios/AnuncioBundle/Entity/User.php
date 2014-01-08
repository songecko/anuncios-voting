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

    public function setIsUsuario($isUsuario)
    {
        $this->isUsuario = $isUsuario;
    
        return $this;
    }

    public function getIsUsuario()
    {
        return $this->isUsuario;
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
}