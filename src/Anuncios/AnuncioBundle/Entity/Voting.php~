<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Voting
 */
class Voting
{
    private $id;
    private $user;
    private $anuncio;

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
}