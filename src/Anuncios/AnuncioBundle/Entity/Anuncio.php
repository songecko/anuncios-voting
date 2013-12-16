<?php

namespace Anuncios\AnuncioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Anuncio
 */
class Anuncio
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $agency;

    /**
     * @var string
     */
    private $advertiser;

    /**
     * @var string
     */
    private $product;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $sector;

    /**
     * @var string
     */
    private $clientContact;

    /**
     * @var string
     */
    private $creativeTeam;

    /**
     * @var string
     */
    private $businessDirection;

    /**
     * @var string
     */
    private $mediaAgency;

    /**
     * @var string
     */
    private $producer;

    /**
     * @var string
     */
    private $director;

    /**
     * @var string
     */
    private $soundStudio;

    /**
     * @var string
     */
    private $piece;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $image;


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
     * @return Anuncio
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
     * Set agency
     *
     * @param string $agency
     * @return Anuncio
     */
    public function setAgency($agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return string 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set advertiser
     *
     * @param string $advertiser
     * @return Anuncio
     */
    public function setAdvertiser($advertiser)
    {
        $this->advertiser = $advertiser;

        return $this;
    }

    /**
     * Get advertiser
     *
     * @return string 
     */
    public function getAdvertiser()
    {
        return $this->advertiser;
    }

    /**
     * Set product
     *
     * @param string $product
     * @return Anuncio
     */
    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return string 
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set brand
     *
     * @param string $brand
     * @return Anuncio
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set sector
     *
     * @param string $sector
     * @return Anuncio
     */
    public function setSector($sector)
    {
        $this->sector = $sector;

        return $this;
    }

    /**
     * Get sector
     *
     * @return string 
     */
    public function getSector()
    {
        return $this->sector;
    }

    /**
     * Set clientContact
     *
     * @param string $clientContact
     * @return Anuncio
     */
    public function setClientContact($clientContact)
    {
        $this->clientContact = $clientContact;

        return $this;
    }

    /**
     * Get clientContact
     *
     * @return string 
     */
    public function getClientContact()
    {
        return $this->clientContact;
    }

    /**
     * Set creativeTeam
     *
     * @param string $creativeTeam
     * @return Anuncio
     */
    public function setCreativeTeam($creativeTeam)
    {
        $this->creativeTeam = $creativeTeam;

        return $this;
    }

    /**
     * Get creativeTeam
     *
     * @return string 
     */
    public function getCreativeTeam()
    {
        return $this->creativeTeam;
    }

    /**
     * Set businessDirection
     *
     * @param string $businessDirection
     * @return Anuncio
     */
    public function setBusinessDirection($businessDirection)
    {
        $this->businessDirection = $businessDirection;

        return $this;
    }

    /**
     * Get businessDirection
     *
     * @return string 
     */
    public function getBusinessDirection()
    {
        return $this->businessDirection;
    }

    /**
     * Set mediaAgency
     *
     * @param string $mediaAgency
     * @return Anuncio
     */
    public function setMediaAgency($mediaAgency)
    {
        $this->mediaAgency = $mediaAgency;

        return $this;
    }

    /**
     * Get mediaAgency
     *
     * @return string 
     */
    public function getMediaAgency()
    {
        return $this->mediaAgency;
    }

    /**
     * Set producer
     *
     * @param string $producer
     * @return Anuncio
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * Get producer
     *
     * @return string 
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * Set director
     *
     * @param string $director
     * @return Anuncio
     */
    public function setDirector($director)
    {
        $this->director = $director;

        return $this;
    }

    /**
     * Get director
     *
     * @return string 
     */
    public function getDirector()
    {
        return $this->director;
    }

    /**
     * Set soundStudio
     *
     * @param string $soundStudio
     * @return Anuncio
     */
    public function setSoundStudio($soundStudio)
    {
        $this->soundStudio = $soundStudio;

        return $this;
    }

    /**
     * Get soundStudio
     *
     * @return string 
     */
    public function getSoundStudio()
    {
        return $this->soundStudio;
    }

    /**
     * Set piece
     *
     * @param string $piece
     * @return Anuncio
     */
    public function setPiece($piece)
    {
        $this->piece = $piece;

        return $this;
    }

    /**
     * Get piece
     *
     * @return string 
     */
    public function getPiece()
    {
        return $this->piece;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Anuncio
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Anuncio
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }
}
