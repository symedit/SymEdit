<?php

namespace Isometriks\Bundle\SymEditBundle\Entity;


/**
 * Isometriks\Bundle\SymEditBundle\Entity\Slider
 */
class Slider
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $description
     */
    private $description;
    
    
    /**
     * @var type 
     */
    private $slides; 


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
     * @return Slider
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
     * Set description
     *
     * @param string $description
     * @return Slider
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->slides = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add slides
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Slide $slides
     * @return Slider
     */
    public function addSlide(\Isometriks\Bundle\SymEditBundle\Entity\Slide $slides)
    {
        $this->slides[] = $slides;
    
        return $this;
    }

    /**
     * Remove slides
     *
     * @param Isometriks\Bundle\SymEditBundle\Entity\Slide $slides
     */
    public function removeSlide(\Isometriks\Bundle\SymEditBundle\Entity\Slide $slides)
    {
        $this->slides->removeElement($slides);
    }

    /**
     * Get slides
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSlides()
    {
        return $this->slides;
    }
}