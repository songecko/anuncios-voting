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
}