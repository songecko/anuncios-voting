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
    private $otherFields;

    /**
     * @var string
     */
    private $image;

    /**
     * @var \Anuncios\AnuncioBundle\Entity\Category
     */
    private $category;


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
     * Set otherFields
     *
     * @param string $otherFields
     * @return Anuncio
     */
    public function setOtherFields($otherFields)
    {
        $this->otherFields = $otherFields;

        return $this;
    }

    /**
     * Get otherFields
     *
     * @return string 
     */
    public function getOtherFields()
    {
        return $this->otherFields;
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

    /**
     * Set category
     *
     * @param \Anuncios\AnuncioBundle\Entity\Category $category
     * @return Anuncio
     */
    public function setCategory(\Anuncios\AnuncioBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Anuncios\AnuncioBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
